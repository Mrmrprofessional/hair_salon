<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/stylist.php";
    require_once "src/client.php";

    $server = 'mysql:host=127.0.0.1;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ClientTest extends PHPUnit_Framework_TestCase {

        function test_getClient()
        {
            //Arrange
            $client = "Fred";
            $stylist_id = 1;
            $id = 1;
            $test_client = new Client($client, $id, $stylist_id);
            //Act
            $result = $test_client->getClient();
            //Assert
            $this->assertEquals($client, $result);
        }

        function test_save()
        {
            $stylist = "Ben";
            $id = null;
            $test_stylist = new stylist($stylist, $id);
            $test_stylist->save();
            $client = "Kim";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($client, $id, $stylist_id);
            //Act
            $test_client->save();
            //Assert
            $result = Client::getAll();
            $this->assertEquals($test_client, $result[0]);
        }

        function test_getId()
        {
            //Arrange
            $stylist = "Monica";
            $id = null;
            $test_stylist = new Stylist($stylist, $id);
            $test_stylist->save();
            $client = "Kim";
            $stylist_id = 1;
            $id = 1;
            $test_client = new client($client, $id, $stylist_id);
            $test_client->save();
            //Act
            $result = $test_client->getId();
            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getStylistId()
        {
            //Arrange
            $stylist = "Jim";
            $id = null;
            $test_stylist = new Stylist($stylist, $id);
            $test_stylist->save();
            $client = "Fred";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($client, $id, $stylist_id);
            $test_client->save();
            //Act
            $result = $test_client->getStylistId();
            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_deleteAll()
        {
            //Arrange
            $stylist = "Kim";
            $id = null;
            $test_stylist = new stylist($stylist, $id);
            $test_stylist->save();
            $client = "Sam";
            $client2 = "Fred";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($client, $id, $stylist_id);
            $test_client->save();
            $test_client2 = new Client($client, $id, $stylist_id);
            $test_client2->save();
            //Act
            Client::deleteAll();
            //Assert
            $result = Client::getAll();
            $this->assertEquals([], $result);
        }
        function test_find()
        {
            //Arrange
            $stylist = "Jess";
            $id = null;
            $test_stylist = new Stylist($stylist, $id);
            $test_stylist->save();
            $client = "tess";
            $client2 = "Stress";
            $stylist_id = $test_stylist->getId();
            $test_client = new client($client, $stylist_id, $id, $rating, $address, $description);
            $test_client->save();
            $test_client2 = new client($client, $stylist_id, $id, $rating, $address, $description);
            $test_client2->save();
            //Act
            $result = client::find($test_client->getId());
            //Assert
            $this->assertEquals($test_client, $result);
        }
        function test_getclients()
        {
            //Arrange
            $stylist = "Jim";
            $id = null;
            $test_stylist = new Stylist($stylist, $id);
            $test_stylist->save();
            $test_stylist_id = $test_stylist->getId();
            $client = "Hana";
            $client2 = "Bani";
            $test_client = new Client($client, $id, $test_stylist_id);
            $test_client2 = new Client($client2, $id, $test_stylist_id);
            $test_client->save();
            $test_client2->save();
            //Act
            $result = $test_stylist->getclients();
            //Assert
            $this->assertEquals([$test_client, $test_client2], $result);
        }
        function test_deleteClient()
        {
            //Arrange
            $stylist = "Sean";
            $id = null;
            $test_stylist = new Stylist($stylist, $id);
            $test_stylist->save();
            $test_stylist_id = $test_stylist->getId();
            $client = "Nacho";
            $client2 = "Bil";
            $test_client = new Client($client, $id, $test_stylist_id);
            $test_client2 = new Client($client2, $id, $test_stylist_id);
            $test_client->save();
            $test_client2->save();
            //Act
            $test_client->deleteClient();
            //Assert
            $this->assertEquals([$test_client2], Client::getAll());
        }

        function testUpdate()
        {
            //Arrange
            $client = "Steve";
            $id = null;
            $stylist_id = 1;
            $test_client = new Client($client, $id, $stylist_id);
            $test_client->save();

            $new_client = "Mike";

            //Act
            $test_client->update($new_client);

            //Assert
            $this->assertEquals("Mike", $test_client->getClient());
        }

        function test_Delete() {
            $client = "Ron";
            $id = null;
            $stylist_id = 1;
            $test_client = new Client($client,  $id, $stylist_id);
            $test_client->save();

            $client2 = "Sean";
            $id2 = null;
            $stylist_id2 = 1;
            $test_client2 = new Client($client2,  $id2, $stylist_id2);
            $test_client2->save();

            $test_client->delete();

            $this->assertEquals([$test_client2], Client::getAll());
        }

    }
?>
