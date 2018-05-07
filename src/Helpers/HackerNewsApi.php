<?php

    namespace HackerNews\Helpers;

    use GuzzleHttp;
    use GuzzleHttp\Exception\ClientException;


    class HackerNewsApi
    {
        /**
         * @var GuzzleHttp\Client
         */
        protected $client;

        /**
         * @var string
         */
        protected $url;

        /**
         * @var string
         */
        protected $type;

        /**
         * @var array
         */
        protected $responseBody;

        /**
         * @var int
         */
        protected $responseCode;

        /**
         * @var string
         */
        protected $responseContentType;

        /**
         * @var array
         */
        protected $availableRequests;

        /**
         * HackerNewsApi constructor.
         * @param array $availableRequests
         */
        public function __construct(array $availableRequests)
        {
            $this->client = new GuzzleHttp\Client();
            $this->availableRequests = $availableRequests;

        }

        /**
         * @param string $url
         * @throws \Exception
         */
        public function setUrl(string $url)
        {

            if (is_string($url) && null != $url) {
                $this->url = $url;
            } else {
                throw new \Exception('Invalid url');
            }
        }

        /**
         * @param string $type
         */
        public function setType(string $type)
        {
            $this->type = $type;
        }

        /**
         * @param string|null $id
         * @return $this
         * @throws GuzzleHttp\Exception\GuzzleException
         */
        public function get(string $id = null)
        {

            try {
                $res = $this->client->request('GET', $this->url . $this->type . (($id) ?? $id) . '.json');
                $this->responseCode = $res->getStatusCode();
                // "200"
                $this->responseContentType = $res->getHeader('content-type');
                // 'application/json; charset=utf8'
                $this->responseBody = json_decode($res->getBody(), true);

            } catch (ClientException $e) {
                //read the log
                //echo $e->getMessage();
                error_log('Invalid api request:' . $e->getMessage());
            }

            return $this;

        }

        /**
         * @return mixed
         */
        public function getResponse()
        {
            return $this->responseBody;
        }

        /**
         * @param int $offset
         * @param int $limit
         * @return array
         * @throws GuzzleHttp\Exception\GuzzleException
         */
        public function getAllItems(int $offset = 0, $limit = 30): array
        {

            $items = [];
            $this->type = $this->availableRequests['item'];
            $responseBody = $this->responseBody;

            $counter = $offset;
            foreach ($responseBody as $item) {
                if ($counter > $offset) {
                    $itemResponse = $this->get($item)->getResponse();

                    if (isset($itemResponse['url'])) {
                        $itemResponse['urlDisplay'] = $this->getDisplayUrl($itemResponse['url']);
                    } else {
                        $itemResponse['url'] = '/item/' . $itemResponse['id'];
                    }

                    if (isset($itemResponse['time'])) {
                        $itemResponse['timeElapsed'] = $this->getElapsedTime($itemResponse['time']);
                    }

                    $items[$item] = $itemResponse;
                }

                $counter++;

                if ($counter == $limit) {
                    break;
                }

            }

            return $items;
        }

        /**
         * @return array
         * @throws GuzzleHttp\Exception\GuzzleException
         */
        public function getItemDetails(): array
        {
            $itemResponse = $this->responseBody;

            if (isset($itemResponse['url'])) {
                $itemResponse['urlDisplay'] = $this->getDisplayUrl($itemResponse['url']);
            } else {
                $itemResponse['url'] = '/item/' . $itemResponse['id'];
            }

            if (isset($itemResponse['kids'])) {
                $itemResponse['comments'] = $this->buildCommentsTree($itemResponse['kids']);
            }

            if (isset($itemResponse['time'])) {
                $itemResponse['timeElapsed'] = $this->getElapsedTime($itemResponse['time']);
            }

            return $itemResponse;
        }

        public function getUserDetails()
        {
            $userResponse = $this->responseBody;

            if (isset($userResponse['created'])) {
                $created = new \DateTime();
                $created->setTimestamp($userResponse['created']);
                $userResponse['created'] = $created->format('F d, Y');
            }

            return $userResponse;
        }


        /**
         * @param string $timestamp
         * @return string
         */
        private function getElapsedTime(string $timestamp)
        {
            $elapsed = null;
            if (strlen($timestamp) == 0) {
                return $elapsed;
            }
            $datetime1 = new \DateTime();
            $datetime1->setTimestamp($timestamp);
            $datetime2 = new \DateTime();
            $interval = $datetime1->diff($datetime2);



            if ($interval->format('%y') > 0) {
                $elapsed = $interval->format('%y years');
            } elseif ($interval->format('%m') > 0) {
                $elapsed = $interval->format('%m months');
            } elseif ($interval->format('%d') > 0) {
                $elapsed = $interval->format('%d days');
            } elseif ($interval->format('%h') > 0) {
                $elapsed = $interval->format('%h hours');
            } elseif ($interval->format('%i') > 0) {
                $elapsed = $interval->format('%i minutes');
            }


            return $elapsed;
        }

        /**
         * @param string $url
         * @return string
         */
        private function getDisplayUrl(string $url)
        {
            $url = explode('/', $url);

            if (isset($url[2])) {
                return $url[2];
            }

            return '';
        }

        /**
         * @param array $kids
         * @return array
         * @throws GuzzleHttp\Exception\GuzzleException
         */
        private function buildCommentsTree(array $kids): array
        {

            $comments = [];

            foreach ($kids as $kid) {
                $comments[] = $this->get($kid)->getItemDetails();
            }

            return $comments;

        }

        /**
         * @param $commentsTree
         * @param $kids
         * @return mixed
         * @throws GuzzleHttp\Exception\GuzzleException
         */
        protected function buildTree(&$commentsTree, $kids)
        {

            foreach ($kids as $kid) {

                $items = $this->get($kid)->getItemDetails();

                if (isset($items['kids'])) {
                    $commentsTree[$kid] = $items;
                    $commentsTree[$kid]['kids'] = $this->buildTree($commentsTree, $items['kids']);
                } else {
                    $commentsTree[$kid] = $items;
                }
            }
            return $commentsTree;
        }


    }