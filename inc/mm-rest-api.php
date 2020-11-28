<?php
/**
 * Class Markers_List_Rest
 */
class Markers_API extends WP_REST_Controller
{
    /**
     * The namespace.
     *
     * @var string
     */
    protected $namespace;
    /**
     * Rest base for the current object.
     *
     * @var string
     */
    protected $rest_base;

    /**
     * Markers_List_Rest constructor.
     */
    public function __construct()
    {
        $this->namespace = 'markers/v1';
        $this->rest_base = 'list';
    }
    /**
     * Register the routes for the objects of the controller.
     */
    public function register_routes()
    {
        register_rest_route($this->namespace, '/' . $this->rest_base, array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_markers' ),
            ),
            'schema' => null,

        ));
    }
    /**
     * Grabs all the markers list.
     *
     * @param WP_REST_Request $request get data from request.
     *
     * @return mixed|WP_REST_Response
     */
    public function get_markers($request)
    {
        $args = array(
            'post_type' => 'markers',
            'posts_per_page'=>-1,
            'numberposts'=>-1
        );
        
        $posts = get_posts($args);
        $taxonomies = get_object_taxonomies('markers');
    
        foreach ($posts as $key => $post) {
            $posts[$key] = get_fields($post->ID);
            $posts[$key]['marker_id'] = $post->ID;
            $posts[$key]['marker_types'] = wp_get_post_terms($post->ID, $taxonomies, array("fields" => "all"));
        }
    

        // Return all of our comment response data.
        return rest_ensure_response($posts);
    }
}
/**
 * Function to register our new routes from the controller.
 */
function register_markers_list_controller()
{
    $controller = new Markers_API();
    $controller->register_routes();
}

add_action('rest_api_init', 'register_markers_list_controller');