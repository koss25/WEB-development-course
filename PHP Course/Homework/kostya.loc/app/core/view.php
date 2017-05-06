<?php

class View {  
  function generate($content_view, $template_view, $data = null) {
    include VIEW.$template_view;
  }
  
}

?>