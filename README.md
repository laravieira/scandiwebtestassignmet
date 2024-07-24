# Scandiweb Test Assignment
###### Version 1.1.1
### Reference Index
1. [What I changed](#markdown-header-changes)
2. [What I tryed to improve](#markdown-header-improvements)
2. [Personal Commentary](#markdown-header-commentary)

## Changes
Based on the feedback, I build these tasks to solve:

* [X] Re-implement router
* [X] Spread STA class
* [X] Move SQL queries to Database class
* [X] Not implicitly create a type inside my code
    * [ ] Understand where is the problem
    * [X] Search others ways instead of `new $type()`
    * [X] Re-implement what I hope was the problem
* [X] Call/load classes without using `__DIR__`
    * [X] Implement class autoloader
* [X] Set the Product class as abstract
    * [X] Take out all static methods to a storage class
    * [X] Change i bit the behavior of products classes

## Improvements
Trying to impress a bit more and get away all the warnings on the Intellij, I get myself improving alot on my code style and I tried to keep it clean... with docs..., ok docs are not the most clean thing in code, but...
_'Hey! I guess I know how to do it : )'_

I hope more feedback about all this.

* [X] Try to implement PSR-12 on all my code style
    * [X] Keep an eye focus on new lines exclusively for brackets of classes and methods
* [X] Reallocate all classes to src folder
    * [X] Follow PRS-4 folder pattern
    * [X] Follow one of the PRS-4 namespace pattern
* [X] Make the products being auto parsed to their specific type all by PDO
* [X] Implement support to get args with REST API URI pattern
* [X] Make sure to use PHP 8 stuff... I mean... Take advantage of PHP 8!
* [X] Document all the code to use IDE auto completion hints
* [X] Try to give more feedback of what I'm doing
* [X] Update the project based on x.y.z versioning pattern

## Version 1.1.1
* [X] Change host provider to [Heroku](https://heroku.com)
* [X] Implemented pipeline to auto deploy
* [X] Use environment vars instead of env file

## Commentary
This is a personal commentary:

I'm... I bit sad... because... I delete it...

The ScandiwebTestAssignment class...

I remove every function of it...

Pressing F :(

This project is being quite challenge,
I spend hours trying to figure out how to call a class explicitly without knowing his name,
I spend hours searching about every way of doing something like that and ask my friend's help... on the end, hahaha,
I found no way to do it,
I probably get that a way off what you ask for, sorry. But again,
I hope you like what I did here.
I, at least, am loving it,
I discovered a lot of new details that
I was missing in my code style before. Thank you for this challenge, and
I hope you want to give me a lot more challenges! : ]