<?php
    namespace HackerNews\Helpers;
    use GuzzleHttp;
    use GuzzleHttp\Exception\ClientException;


    class HackerNewsApi
    {
        protected $client;
        protected $url;
        protected $type;

        public function __construct()
        {
            $this->client = new GuzzleHttp\Client();
            $this->availableRequests = [];

        }

        public function setUrl( string $url )
        {

            if ( is_string($url) && null != $url  ) {
                $this->url = $url;
            }
            else
            {
                throw new \Exception('Invalid url');
            }
        }

        public function setType( string $type )
        {
            $this->type = $type;
        }

        public function get( int $id = null)
        {

            try
            {
                $res = $this->client->request('GET', $this->url . $this->type . (($id)??$id) . '.json');
                echo $res->getStatusCode();
                // "200"
                echo $res->getHeader('content-type');
                // 'application/json; charset=utf8'
                $result =  $res->getBody();
            }catch( ClientException $e )
            {
                //read the log
                //echo $e->getMessage();
                echo 'Invalid api request';
                $result = json_encode([]);
            }

            return $result;

        }

    }