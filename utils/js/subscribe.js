
$(document).ready(function() {
    
    $("#button_subscribe").live('click', function(event) {
        if($("#content_subscribe").css("display") === "block")
            $("#content_subscribe").css({"display":"none"});
        else
        {
            event.stopPropagation();
            $("#button_subscribe").addClass("buttonselected");
            $("#content_subscribe").css({"display":"block"});
            $("#button_connexion").removeClass("buttonselected");
            $("#content_connexion").css({"display":"none"});
        }
    });
    
    $("html").live('click', function(e) {
        
        hasParent = false;
        for(var node = event.target; node !== document.body; node = node.parentNode)
        {
          if(node.id === 'content_subscribe'){
            hasParent = true; 
            break;
          }
        }
        
        if(!hasParent)
        {
            $("#button_subscribe").removeClass("buttonselected");
            $("#content_subscribe").css({"display":"none"});
        }
    });
    
});

