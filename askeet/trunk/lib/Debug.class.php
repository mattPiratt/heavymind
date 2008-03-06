<?php
class Debug {
  
  public static function show( $input ) {
    print('<pre>');
    print_r( $input );
    print('</pre>');
  }
}
?>