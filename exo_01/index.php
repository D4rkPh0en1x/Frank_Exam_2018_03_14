<?php
//create an associative array with all data asks and birthdate in english format
$userArray = [ 'firstName' => 'Frank', 'lastName' => 'Schroeder', 'address' => '40 route d\'arlon',
               'postalCode' => '4830', 'city' => 'Rodange', 'email' => 'frank@eliza.family', 
               'telephone' => '691583162', 'birthdate' => '1978-06-09'];

//create a loop for displaying the data of the array
foreach ($userArray as $key => $value){
    //if the $key variable is not birthdate simply display the data in the list
    if ($key != 'birthdate'){
        echo '<li>' . $key . ' = ' . $value . '</li>';
        echo '<hr/>';
    }else{
        //if the $key is birthdate we have to create a DateTime format from the given string
        $date = DateTime::createFromFormat('Y-m-d', $value);
        //than we can give out the $date in the asked format
        echo '<li>' . $key . ' = ' . $date->format('d-m-Y') . '</li>';
        echo '<hr/>';
    }
}
?>
