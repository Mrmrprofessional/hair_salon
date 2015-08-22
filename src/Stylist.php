<?php
    class stylist
    {
        private $stylist;
        private $id;

        function __construct($stylist, $id = null)
        {
            $this->stylist = $stylist;
            $this->id = $id;
        }

        function setStylist($new_stylist)
        {
            $this->stylist = (string) $new_stylist;
        }

        function getStylist()
        {
            return $this->stylist;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO stylists (stylist) VALUES ('{$this->getstylist()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
            // $this->setId($result_id);
        }

        static function getAll()
        {
            $returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
            $stylists = array();
            foreach($returned_stylists as $styler) {
                $stylist = $styler['stylist'];
                $id = $styler['id'];
                $new_stylist = new stylist($stylist, $id);
                array_push($stylists, $new_stylist);
            }
            return $stylists;
        }

        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM stylists;");
        }


        static function find($search_id)
        {
            $found_stylist = null;
            $stylists = Stylist::getAll();
            foreach($stylists as $styler) {
                $stylist_id = $styler->getId();
                if ($stylist_id == $search_id) {
                  $found_stylist = $stylist;
                }
            }
            return $found_stylist;
        }

        function getclients()
        {
            $clients = Array();
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients WHERE stylist_id = {$this->getId()} ORDER BY client;");
            foreach($returned_clients as $client) {
                $client = $client['client'];
                $stylist_id = $client['stylist_id'];
                $id = $client['id'];
                $new_client = new client($client,  $id, $stylist_id);
                array_push($clients, $new_client);
            }
            return $clients;
        }

        function update($new_stylist) {
            $GLOBALS['DB']->exec("UPDATE stylists SET stylist = '{$new_stylist}' WHERE id = {$this->getId()};");
            $this->setstylist($new_stylist);
        }

        function delete() {
            $GLOBALS['DB']->exec("DELETE FROM stylists WHERE id = {$this->getId()}; DELETE FROM clients WHERE stylist_id = {$this->getId()};");
        }

        static function findEverything($search_stylist)
        {
            $found_search = null;
            $stylists = Stylist::getAll();
            $clients = Client::getAll();
            $searchables = array_merge($clients, $stylists);
            foreach($searchables as $searchable) {
                if(get_class($searchable) == "stylist"){
                    if($searchable->getstylist() == $search_stylist) {
                        $found_search = $searchable;
                    }
                }
                elseif($searchable->getclient() == $search_stylist) {
                    $found_search = $searchable;
                }
            }
            return $found_search;
        }


    }


?>
