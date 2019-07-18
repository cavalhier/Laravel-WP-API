<?php namespace Labchain\LaravelWpApi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class WpApi
{

    /**
     * Guzzle client
     * @var Client
     */
    protected $client;

    /**
     * WP-WPI endpoint URL
     * @var string
     */
    protected $endpoint;

    /**
     * Auth headers
     * @var string
     */
    protected $auth;

    /**
     * Constructor
     *
     * @param string $endpoint
     * @param Client $client
     * @param string $auth
     */
    public function __construct()
    {
        $this->endpoint = env('ENDPOINT');
        $this->client = new Client();
        $this->auth = env('AUTH');
    }

    /**
     * Get all posts
     *
     * @param int $page
     * @return array
     */
    public function posts($page = null)
    {
        return $this->get('posts', '?_embed');
    }

    /**
     * Get all pages
     *
     * @param int $page
     * @return array
     */
    public function pages($page = null)
    {
        return $this->get('posts', ['type' => 'page', 'page' => $page]);
    }

    /**
     * Get post by slug
     *
     * @param string $slug
     * @return array
     */
    public function post($slug)
    {
        return $this->get('posts', ['filter' => ['name' => $slug]]);
    }

    /**
     * Get page by slug
     *
     * @param string $slug
     * @return array
     */
    public function page($slug)
    {
        return $this->get('posts', ['type' => 'page', 'filter' => ['name' => $slug]]);
    }


    public function getPostCategories($id)
    {
        return $this->get('posts?categories='. $id . '&_embed');
    }

    /**
     * Get all categories
     *
     * @return array
     *
     */
    public function getCategories()
    {
        return $this->get('categories?_embed');
    }
    /**
     * Get all categories
     * @param $id
     * @return array
     */
    public function postDetails($id)
    {
        return $this->get('posts/?_embed&slug='. $id  );
    }

    public function getPostComments($id)
    {
        return $this->get('comments?_embed&post='. $id);
    }


    /**
     * Get all tags
     *
     * @return array
     */
    public function tags()
    {
        return $this->get('taxonomies/post_tag/terms');
    }

    /**
     * Get posts from category
     *
     * @param string $number
     *
     * @return array
     */
    public function categoryPosts($id, $limit = null)
    {
        if ($limit)
            $limit = '&per_page=' . $limit;
        return $this->get('posts?_embed&categories=', $id . $limit);
    }

    /**
     * Get posts by author
     *
     * @param string $name
     * @param int $page
     * @return array
     */
    public function authorPosts($id)
    {
        return $this->get('posts?author='.$id.'&_embed&per_page=25');
    }

    /**
     * Get posts tagged with tag
     *
     * @param string $tags
     * @param int $page
     * @return array
     */
    public function tagPosts($tags, $page = null)
    {
        return $this->get('posts', ['page' => $page, 'filter' => ['tag' => $tags]]);
    }

    /**
     * Search posts
     *
     * @param string $query
     * @param int $page
     * @return array
     */
    public function search($post)
    {
        return $this->get('posts?search='. $post . '&per_page=50&_embed');
    }

    /**
     * Get posts by date
     *
     * @param int $year
     * @param int $month
     * @param int $page
     * @return array
     */
    public function archive($year, $month, $page = null)
    {
        return $this->get('posts', ['page' => $page, 'filter' => ['year' => $year, 'monthnum' => $month]]);
    }

    /**
     * Get data from the API
     *
     * @param string $method
     * @param array $query
     * @return array
     */
    public function get($method, $query = null)
    {
        try {

            if ($this->auth) {
                $query['auth'] = $this->auth;
            }
            $response = $this->client->get($this->endpoint . $method . $query);

            $return = [
                'results' => json_decode((string)$response->getBody(), true),
                'total' => $response->getHeaderLine('X-WP-Total'),
            ];

        } catch (RequestException $e) {

            $error['message'] = $e->getMessage();

            if ($e->getResponse()) {
                $error['code'] = $e->getResponse()->getStatusCode();
            }

            $return = [
                'error' => $error,
                'results' => [],
                'total' => 0,
                'pages' => 0
            ];

        }

        return $return;

    }
}
