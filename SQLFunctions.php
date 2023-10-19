<?php

    function connectDB(){
        $serverName = "sql307.infinityfree.com";
        $sqlUsername = "if0_35196903";
        $password = "cmLs3CuywJgmd";
        $dbname = "if0_35196903_sis";
        $conn = mysqli_connect($serverName, $sqlUsername, $password, $dbname);
        if (!$conn){
            die("Connection to DB failed: " . mysqli_connect_error() . "<br>");
        }
        return $conn;
    }

    function exeSQL($conn, $sql){
        $result = mysqli_query($conn, $sql);
        if ($result){
            echo "$sql is executed successfully.<br>";
        } else {
            echo "Error in running sql: " . $sql . " with error: " . mysqli_error($conn) . ".<br>";
        }
        return $result;
    }

    //function is used to see all values stored in DB, except passwords
    function showResults($result){
        if (mysqli_num_rows($result) > 0){
            echo "<table border = '1'>";
            echo "<tr>";

            while ($fieldInfo = mysqli_fetch_field($result)){
                if ($fieldInfo -> name != "password"){
                    echo "<th>{$fieldInfo -> name}</th>";
                }
            }
            echo "</tr>";

            while ($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                foreach($row as $key => $value){
                    if ($key == "password"){
                        continue;
                    }
                    if ($key == "photo"){
                        echo "<td><img src = '" . $value . "' width = '100px'></td>";
                    } else {
                        echo "<td>$value</td>";
                    }
                }

                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No results were found.<br>";
        }
    }

    function disconnectDB($conn){
        mysqli_close($conn);
    }

    function createTable(){
        $sql = "CREATE TABLE Shelves ( shelfNumber INT NOT NULL, itemName VARCHAR(64) NOT NULL, itemQuantity INT NOT NULL )";

        exeSQL($conn, $sql);
    }


?>