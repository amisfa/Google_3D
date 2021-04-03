
//add below code to function.php:
// Display Fields
add_action('woocommerce_product_options_general_product_data', 'woocommerce_product_3DSchema_fields');
// Save Fields
add_action('woocommerce_process_product_meta', 'woocommerce_product_3DSchema_fields_save');
function woocommerce_product_3DSchema_fields()
{
    global $woocommerce, $post;
    echo '<div class="product_3DSchema_field">';
    echo '<h3>تنها برای اسکیما 3D</h3>';
    echo '<h4>فقط در صورتی که میخوای این ساختار تو این صفحه محصولت باشه، فایل رو تو هاست دانلود آپلود کن و لینکشو اینجا قرار بده</h4>';
//field input
woocommerce_wp_text_input(
array(
    'id' => '_3DSchema_product__glb',
    'placeholder' => 'نسخه glb :',
    'label' => __('glb', 'woocommerce'),
    'style'=>'direction: ltr;'
)
);
woocommerce_wp_text_input(
        array(
    'id' => '_3DSchema_product__usdz',
    'placeholder' => 'نسخه usdz :',
    'label' => __('usdz', 'woocommerce'),
    'style'=>'direction: ltr;'
)
    );
    echo '</div>';
}


function woocommerce_product_3DSchema_fields_save($post_id)
{
// glb field
    $woocommerce_3DSchema_product_glb = $_POST['_3DSchema_product__glb'];
    // if (!empty($woocommerce_3DSchema_product_glb))
        update_post_meta($post_id, '_3DSchema_product__glb', esc_attr($woocommerce_3DSchema_product_glb));
        
        // USDZ field
    $woocommerce_3DSchema_product_USDZ = $_POST['_3DSchema_product__usdz'];
    // if (!empty($woocommerce_3DSchema_product_USDZ))
        update_post_meta($post_id, '_3DSchema_product__usdz', esc_attr($woocommerce_3DSchema_product_USDZ));
        
        
}
function schema_3D(){
if(is_singular( 'product' )){
$product = wc_get_product();
$id = $product->get_id();
$product_img=wp_get_attachment_url( $product->get_image_id() );
$get_usdz=get_post_meta($id, '_3DSchema_product__usdz', true);
$get_glb=get_post_meta($id, '_3DSchema_product__glb', true);

if(!$get_usdz=='' && !$get_glb==''){
    echo '<script type="application/ld+json">
    {
        "@graph": [
            {
                "@context": "http://schema.org",
                "@type": "3DModel",
                "image": "'.$product_img.'",
                "name": "Keurig K-Mini Single-Serve K-Cup Pod Coffee Maker - Black",
                "encoding": [
                    { "@type": "MediaObject", "contentUrl": "'.$get_glb.'", "encodingFormat": "model/gltf-binary" },
                    { "@type": "MediaObject", "contentUrl": "'.$get_usdz.'", "encodingFormat": "model/vnd.usdz+zip" }
                ]
            }
        ]
    }
</script>';

}}
}
add_action('wp_footer','schema_3D');
