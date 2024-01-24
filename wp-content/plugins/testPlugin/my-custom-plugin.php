<?php


/* Tarea 1 : - Crear un Plugin Básico:



/* 
Plugin Name: Test Plugin
Plugin URI: https://portafolio-nicolas-gonzalez.vercel.app
Description: Mi plugin personalizado...
Version: 0.01
*/


/* Tarea 2- Agregar una Página de Configuración:

*/

add_action('admin_menu', 'CrearMenu');

function CrearMenu()
{
    add_menu_page(
        'Prueba Tecnica',
        'Prueba',  // title wordpres
        'manage_options',
        'sp_menu',  // url =>  page=sp_menu
        'MostrarContenido', 
        plugin_dir_url(__FILE__) . 'admin/task.png', // icon del panel
        1
    );

    // Agregamos una subpágina para configuración
    add_submenu_page(
        'sp_menu', // Slug del menú padre
        'Configuración',
        'Configuración',
        'manage_options',
        'sp_configuracion',
        'MostrarConfiguracion',

    );
}

function MostrarContenido()
{
    // obtener las opciones almacenadas en la base de datos


    // recuperamos la data almacenada
    $color_fondo = get_option('color_fondo', '#f3f3f3'); // Valor predeterminado: blanco
    $texto_personalizado = get_option('texto_personalizado', '');


    // Aplicamos el estilo al contenido

    echo "<div style='background-color: $color_fondo; padding: 10px;'>";


    echo "<h1>Contenido Estatico</h1>" . '<h2>Bienvenido! </h2>';

    echo "Contenido dinamico :" . "<p>$texto_personalizado</p>";
    echo "</div>";
}

function MostrarConfiguracion()
{




    // * Comprobamos si el formulario fue enviado*

    // isset => determinar si una variable está definida y no es NULL
    if (isset($_POST['guardar_configuracion'])) {

        // *guardamos las opciones en la base de datos* 

        // update_option => permite almacenar valores y se recuperan con get_option

        update_option('color_fondo', $_POST['color_fondo']);

        // sanitize_text_field => limpiar el valor ingresado en el campo de texto antes de guardarlo 


        update_option('texto_personalizado', sanitize_text_field($_POST['texto_personalizado']));
        echo "<div class='updated'><p>Configuración guardada</p></div>";
    }

    // *Obtenemos las opciones almacenadas en la base de datos*

    $color_fondo = get_option('color_fondo', '#ffffff'); // Valor predeterminado: blanco
    $texto_personalizado = get_option('texto_personalizado', '');

    // Mostramos el formulario de configuración
?>

    <div>
        <h1>Configuración del Plugin</h1>
        <form method="post" action="">
            <label for="color_fondo">Select Background:</label>
            <input type="color" name="color_fondo" value="<?php echo esc_attr($color_fondo); ?>"><br>

            <label for="texto_personalizado">Texto Personalizado:</label>
            <input style="margin-top: 10px;" type="text" name="texto_personalizado" value="<?php echo esc_attr($texto_personalizado); ?>"><br>
            
            
            <!---esc_aatr  => sanea una cadena  -->

            <!--btn submit-->
            <input type="submit" name="guardar_configuracion" class="button button-primary" style="margin-top: 10px;" value="Guardar Configuración">
        </form>
    </div>

<?php
}







/* Integración con WooCommerce:

Tarea 3- Crea una funcionalidad que muestre un campo de entrada adicional en la página de productos de WooCommerce para ingresar información adicional del producto (puede ser un número de serie, por ejemplo).

Guarda esta información en la base de datos y asegúrate de que sea visible en la página de detalles del producto.*/


// panel/productos/1/datos_del_producto
function agregar_campo_personalizado_woocommerce()
{
    woocommerce_wp_text_input(


        // __ => sirve para que sea traducible en diferentes idiomas
        array(
            'id'          => '_numero_serie',   // id 
            'label'       => __('Número de Serie(campo personalizado)', 'woocommerce'), //Etiqueta que se muestra junto al campo
            'placeholder' => __('Ingrese el número de serie', 'woocommerce'), // texto dentro de input
            'desc_tip'    => 'true',  // agrega info adicional al pasar el mouse
            'description' => __('Ingrese el número de serie para este producto.', 'woocommerce'), // breve descripcion se encuentra en el icono " ? "
        )
    );
}
add_action('woocommerce_product_options_general_product_data', 'agregar_campo_personalizado_woocommerce');

// Guardar el valor del campo personalizado en WooCommerce
function guardar_campo_personalizado_woocommerce($product_id)
{

    // Obtengo el valor del campo personalizado del formulario POST y sanitizarlo

    $numero_serie = isset($_POST['_numero_serie']) ? sanitize_text_field($_POST['_numero_serie']) : '';

    // Actualizo el valor del campo personalizado en la meta del producto

    update_post_meta($product_id, '_numero_serie', $numero_serie);
}

// Añadir la acción para ejecutar la función al guardar o actualizar un producto en WooCommerce
add_action('woocommerce_process_product_meta', 'guardar_campo_personalizado_woocommerce');

// Mostrar el número de serie en la página de detalles del producto
function mostrar_numero_serie_en_detalle_producto_woocommerce()
{
    $numero_serie = get_post_meta(get_the_ID(), '_numero_serie', true);

    if (!empty($numero_serie)) {
        echo '<p style="font-size:22px;color:#00296b";text-align:center;><strong>Número de Serie:</strong> ' . esc_html($numero_serie) . '</p>';
    }
}
add_action('woocommerce_before_single_product', 'mostrar_numero_serie_en_detalle_producto_woocommerce');






/*Tarea 4-Integración con API Externa:*/




// Agregar una  secciónen el panel de administración para mostrar datos de la API externa

function agregar_seccion_api_externa()
{
    add_menu_page(
        'Datos de API Externa',
        'DATA API ',
        'manage_options',
        'pagina_api_externa',
        'mostrar_datos_api_externa',
        '',
        1
    );
}
add_action('admin_menu', 'agregar_seccion_api_externa');

// Obtener y mostrar datos de la API externa
function mostrar_datos_api_externa()
{

    // api url
    $url_api_externa = 'https://jsonplaceholder.typicode.com/users';
    // respuesta
    $response = wp_remote_get($url_api_externa);


    if (!is_wp_error($response)) {
        $body = wp_remote_retrieve_body($response); //obtener el contenido de la respuesta de una solicitud HTTP 
        $data = json_decode($body);  //  transformar la cadena JSON en un array 

        if ($data) {
            echo '<div >';
            echo '<h1 style="text-align:center; margin:3rem 0rem; ">Productos electrónicos</h1>';
            echo '<ul>';
            // esc_html se utiliza para escapar el contenido de la variable
            echo '<div style="display: grid;  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); grid-auto-rows: minmax(100px, auto); gap: 20px;">';
            foreach ($data as $user) {
                echo '<div style="margin-bottom: 15px; padding: 15px; background-color: #fff; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">';

                // imagen estatica, ya que la api no tiene para renderizar imagenes
                echo '<img src="https://www.torca.com.ar/images/000000000006320905780acel1.jpg" alt="image-ficticia" style="width: 100%; max-height: 300px; object-fit: cover; border-radius: 8px; ">';
                echo '<p style="margin: 0;"><strong>UserName:</strong> ' . esc_html($user->name) . '</p>';
                echo '<p style="margin: 0;"><strong>Email:</strong> ' . esc_html($user->email) . '</p>';
                echo '<p style="margin: 0;"><strong>Website:</strong> <a href="' . esc_url($user->website) . '" target="_blank">' . esc_html($user->website) . '</a></p>';
                echo '<button style="padding: 8px 12px; background-color: #3498db; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin:0.5rem 0rem; width:100%;">Comprar</button>';
                echo '</div>';
            }

            echo '</div>';

            echo '</ul>';
            echo '</div>';
        } else {
            echo '<p>No se pudieron recuperar datos de la API externa.</p>';
        }
    } else {
        echo '<p>Hay un error  al conectar con la API externa.</p>';
    }
}




/*tarea  5 Crea un widget personalizado que muestre información relacionada con los productos en la barra lateral de la tienda.   

Se encuentra en themes/twentyTwentyone/functions.php
(al final )


*/ 


/*Tarea 6-Crea un shortcode que pueda ser utilizado en las páginas o entradas para mostrar información específica de los productos.*/

// short code

// funcion que renderiza los datos del shortcode
function product_data()
{
    // contenido del shortcode...
    $output = '<div">';
    $output .= '<h2>Encabezado generado con un short code</h2>';
    $output .= '<p>Parrafo generado con short Code ...</p>';
    $output .= '</div>';

    return $output;
}

// Registrar el shortcode :

// add_shortcode => añadimos la funcion shortcode que recibe el parametro info(que es como activamos nosotros en el shortcode los datos) / [info]  /   , y a la derecha lo que muestra o renderiza.
add_shortcode('info', 'product_data');







