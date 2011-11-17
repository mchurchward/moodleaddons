block_twitter_search_callbacks = window.block_twitter_search_callbacks || new Array

function block_twitter_search_update(theurl,callback){
  YAHOO.util.Connect.asyncRequest('GET', theurl, callback);
}

function block_twitter_search_callback(bid){
  var handleSuccess = function(o){
    div = document.getElementById('block_twitter_search_list_' + o.argument.blockid);
    if(o.responseText !== undefined){
      div.innerHTML = o.responseText;
    }
  }  

  var handleFailure = function(o){
    if(o.responseText !== undefined){
      div = document.getElementById('block_twitter_search_list_' + o.argument.blockid);
      div.innerHTML = "<li>Transaction id: " + o.tId + "</li>";
      div.innerHTML += "<li>HTTP status: " + o.status + "</li>";
      div.innerHTML += "<li>Status code message: " + o.statusText + "</li>";
    }
  }

  var callback = {
    customevents: {
      onStart:    function(eventType,args){ 
        YAHOO.util.Dom.setStyle('block_twitter_search_spinner_' + bid,'display','inline'); 
        YAHOO.util.Dom.setStyle('block_twitter_search_update_' + bid,'display','none');
      },
      onComplete: function(eventType,args){ 
        YAHOO.util.Dom.setStyle('block_twitter_search_spinner_' + bid,'display','none'); 
        YAHOO.util.Dom.setStyle('block_twitter_search_update_' + bid,'display','inline');
      }
    },
    success:    handleSuccess,
    failure:    handleFailure,
    argument: { blockid:bid }
  };
 
  return callback;

};
