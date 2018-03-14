<?php
//create the converter function with 2 arguments -- Amout and convert to what to currency

/**Converts the given $inputAmount to a given $convertToCurrency
 * 
 * Only EUR or USD are supported for now
 * 
 * @param float or int $inputAmount
 * @param EUR or USD $convertToCurrency
 */
function currencyConverter($inputAmount, $convertToCurrency){
    //check if the given data are in the correct format
    if ((is_int($inputAmount) || is_float($inputAmount)) && ($convertToCurrency == 'EUR' || $convertToCurrency == 'USD')){
        //setting the variable for the currency EUR in USD
        $one_EUR_in_USD="1.085965";
        //the variable needs to be set to the correct type
        settype($one_EUR_in_USD, "float");
        //if the amount should be converted to EUR
            if ($convertToCurrency == 'EUR'){
                $calcResult = $inputAmount * $one_EUR_in_USD;
                //echo the result of the calculation
                echo "Your $inputAmount &euro; is/are worth $calcResult $"; 
                return;
            }
        //when not converted to EUR it should be converted to USD    
        $calcResult = $inputAmount / $one_EUR_in_USD;
        //echo the result of the calculation
        echo "Your $inputAmount $ is/are worth $calcResult &euro;";
        return;
    };
}

//for function test
currencyConverter(1343.21441, 'USD');

?>