curl-object
===========

A simple wrapper for the default curl functions in PHP. This script provides the CURL class which is used as an object instead of a handle.

# Usage

## Constructor

The constructor takes one, two or three arguments, the first argument is mandatory and represents the url to call. The second argument is optional and lets you choose between `get` and `post` (`delete` is just get) (default='get'). The third argument is the post variables (default='').

## Options

The default function to set an option is `setOption($key,$value)`. This function is a direct wrapper for the `curl_setopt($ch,$key,$value)` function. Other functions for setting options are: `setUrl`, `setHeader`, `setReturn` and `setPostfields`. These functions all call `setOption`, but you don't have to memorize the corresponding curl constant.

## Running cURL

To execute a cURL action use the function `exec`, this function just executes the action. Use `getResponse` afterwards to fetch the response, if you expected one.

## Example 1

    // Print the contents of the response
    $ch = new CURL('http://www.w3schools.com/html/tryhtml_nestedlists2.htm');
    
    $ch->setReturn(false);
    
    $ch->exec();

## Example 2

    // Save the content of the response in a variable
    $ch = new CURL('http://www.w3schools.com/html/tryhtml_nestedlists2.html');

    $ch->exec();

    $result = $ch->getResponse();

# Notes

This script is far from finished, I am mostly use it in my own projects and I update it when I need more functionality. If you think this script would be useful for you, feel free to use it