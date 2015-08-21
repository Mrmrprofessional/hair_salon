<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Stylist.php";
    require_once "src/Client.php";

    $server = 'mysql:host=localhost;dbclient=hair_dresser_test';
    $userclient = 'root';
    $password = 'root';
    $DB = new PDO($server, $userclient, $password);

    class StylistTest extends PHPUnit_Framework_TestCase {

        protected function tearDown() {
            Stylist::deleteAll();
            Client::deleteAll();
        }

        function test_getstylist()
        {
            //Arrange
            $stylist = "John";
            $test_stylist = new Stylist($stylist);

            //Act
            $result = $test_stylist->getstylist();

            //Assert
            $this->assertEquals($stylist, $result);
        }

        function test_getId()
        {
            //Arrange
            $stylist = "Bob";
            $id = 1;
            $test_stylist = new Stylist($stylist, $id);

            //Act
            $result = $test_stylist->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $stylist = "John";
            $test_stylist = new Stylist($stylist);
            $test_stylist->save();

            //Act
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals($test_stylist, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $stylist = "Kim";
            $stylist2 = "Bill";
            $test_stylist = new Stylist($stylist);
            $test_stylist->save();
            $test_stylist2 = new Stylist($stylist2);
            $test_stylist2->save();

            //Act
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals([$test_stylist, $test_stylist2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $stylist = "Brock";
            $stylist2 = "Luane";
            $test_stylist = new Stylist($stylist);
            $test_stylist->save();
            $test_stylist2 = new Stylist($stylist2);
            $test_stylist2->save();

            //Act
            Stylist::deleteAll();
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $stylist = "Bill";
            $stylist2 = "Tommy";
            $test_stylist = new Stylist($stylist);
            $test_stylist->save();
            $test_stylist2 = new Stylist($stylist2);
            $test_stylist2->save();

            //Act
            $result = Stylist::find($test_stylist->getId());

            //Assert
            $this->assertEquals($test_stylist, $result);
        }

        function test_update()
        {
            //Arrange
            $stylist = "Italian";
            $id = null;
            $test_stylist = new stylist($stylist, $id);
            $test_stylist->save();

            $new_stylist_stylist = "Thai";

            //Act
            $test_stylist->setstylist($new_stylist_stylist);

            //Assert
            $this->assertEquals($new_stylist_stylist, $test_stylist->getstylist());
        }

        function test_Update() {
            $stylist = "Jen";
            $id = null;
            $test_stylist = new Stylist($stylist,$id);
            $test_stylist->save();

            $new_stylist = "Jennifer";

            $test_stylist->update($new_stylist);

            $this->assertEquals("Jennifer", $test_stylist->getStylist());
        }

        function test_Delete() {
            $stylist = "Jen";
            $id = null;
            $test_stylist = new Stylist($stylist, $id);
            $test_stylist->save();

            $stylist2 = "Kim";
            $test_stylist2 = new Stylist($stylist2, $id);
            $test_stylist2->save();

            $test_stylist->delete();

            $this->assertEquals([$test_stylist2], Stylist::getAll());
        }

        function testFindEverything()
        {
            //Arrange
            $stylist = "Kim";
            $id = null;
            $test_stylist = new stylist($stylist, $id);
            $test_stylist->save();

            $client = "Jack";
            $id = "4";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($client, $id, $stylist_id);
            $test_client->save();

            //Act
            $result = Stylist::findEverything($test_client->getclient());

            //Assert
            $this->assertEquals([$test_client], $result);
        }


    }

 ?>
