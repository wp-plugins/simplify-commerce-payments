<?php
    global $PaymentSuccessfull, $asp_error,$item_url;
    if($PaymentSuccessfull) {
        
        if(!empty($content)) {
            echo $content;
        }
        else 
            echo __('Thanks for your purchase.');

        if(!empty($item_url)) {
            echo "Your download should auto start, if it does not, please <a href='".base64_decode($item_url)."'>click here</a> to download.";
?>
        <script type="text/javascript">
        // add relevant message above or remove the line if not required
        window.onload = function(){
              window.location = "<?php echo base64_decode($item_url);?>";
        };
                                        
        </script>
<?php
        }
    }
    else
    {
        echo __("System was not able to complete the payment.".$asp_error);
    }
?>