<?php

/* Twitter Search block
   This block shows the tweets resulting from a particular search. The search terms and no of results are configurable.

   Now with extra AJAX goodness - it will update itself in the sidebar; set polling time to 0 to stop this.
   Sorry if the AJAX stuff's odd; I haden't used YUI before :)
   
   Multilingual support and Hebrew translation by Nadav Kavalerchik
   Catalan translation by Joan Queralt
*/

class block_twitter_search extends block_base {
  function init() {
    $this->title   = get_string('blocktitle','block_twitter_search');
    $this->version = 2010020201;
  }

  function instance_allow_multiple(){
    return true;
  }

  function specialization() {
    if(empty($this->config->search_string)){
      $this->config->search_string = '#moodle';
    }
    if(empty($this->config->no_tweets)){
      $this->config->no_tweets = 10;
    }
    if(empty($this->config->polltime)){
      $this->config->polltime = 30000;
    }
  }

  function get_content() {
    if ($this->content !== NULL) {
      return $this->content;
    }

    global $CFG, $USER;

    $search_string = $this->config->search_string;
    $search_string_enc = urlencode($search_string);
    $no_tweets      = $this->config->no_tweets;
    $url = "http://search.twitter.com/search.atom?q=$search_string_enc&rpp=$no_tweets";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $xml = curl_exec($ch);
    curl_close($ch);
    $dom = DOMDocument::loadXML($xml);
    $tweets = $dom->getElementsByTagName('entry');

    $update_js = "block_twitter_search_update(\"".$CFG->wwwroot."/blocks/twitter_search/ajax_update.php?blockid=".$this->instance->id."\",block_twitter_search_callbacks[".$this->instance->id."]);return false;";
    $output = "
      <script type=\"text/javascript\" src=\"".$CFG->wwwroot.'/blocks/twitter_search/javascript.js'."\"></script>
      <script type=\"text/javascript\" src=\"".$CFG->wwwroot.'/lib/yui/yahoo/yahoo-min.js'."\"></script>
      <script type=\"text/javascript\" src=\"".$CFG->wwwroot.'/lib/yui/dom/dom-min.js'."\"></script>
      <script type=\"text/javascript\">
        block_twitter_search_callbacks[".$this->instance->id."]=block_twitter_search_callback(".$this->instance->id.");
        setInterval(function(){ $update_js }, ".$this->config->polltime.");
      </script>
      <ul class='list' id='block_twitter_search_list_".$this->instance->id."'>
    ";

    foreach ($tweets as $tweet) {
      $output .= "<li class='tweet'>";
      $author = $tweet->getElementsByTagName('author')->item(0);
      $authorname = $author->getElementsByTagName('name')->item(0)->textContent;
      $authorlink = $author->getElementsByTagName('uri')->item(0)->textContent;
      $output .= "<a href='$authorlink'>$authorname</a>: ";
      $output .= format_text($tweet->getElementsByTagName('content')->item(0)->textContent,FORMAT_HTML);
      $output .= "</li>";
    }
    $output .= "</ul>";
    $this->title           = $search_string.get_string('ontwitter','block_twitter_search');
    $this->content         =  new stdClass;
    $this->content->text   = $output;
    $this->content->footer = "<a href='#' id='block_twitter_search_update_".$this->instance->id."' onclick='$update_js'>update</a><img src='".$CFG->wwwroot."/pix/i/loading_small.gif' style='display:none' id='block_twitter_search_spinner_".$this->instance->id."' />";

    return $this->content;
  }
}
?>
