
$(document).ready(function() {
    
    $("#button_connexion").live('click', function(event) {
        if($("#content_connexion").css("display") === "block")
        {
            $("#button_connexion").removeClass("buttonselected");
            $("#content_connexion").css({"display":"none"});
        }
        else
        {
            event.stopPropagation();
            $("#button_connexion").addClass("buttonselected");
            $("#content_connexion").css({"display":"block"});
            $("#button_subscribe").removeClass("buttonselected");
            $("#content_subscribe").css({"display":"none"});
        }
    });
    
    $("html").live('click', function(e) {
        
        hasParent = false;
        for(var node = e.target; node !== document.body; node = node.parentNode)
        {
          if(node.id === 'content_connexion'){
            hasParent = true;
            break;
          }
        }
    
        if(!hasParent)
        {
            $("#button_connexion").removeClass("buttonselected");
            $("#content_connexion").css({"display":"none"});
        }
     });
    
});
