#libMBTA 

I needed to write a toy that queried the MBTA live data API, but I was sad to discover that there wasn't a PHP library for doing so. I could have written just the parts I wanted, but I figured that someone else might want to write a toy like mine some day, so why not flesh out the library to handle all kinds of things? So here is libMBTA. 

The code is rough. It was largely written within a single 24 hour period. There are no guarantees of well-written code, as I'm not inately a programmer, I'm just a guy who can program. As such, buyer beware and please submit pull requests when you inevitably find errors or better ways to do things. 

Practically, there's not much value-add here in this library at the moment. It's essentially passing through requests to the REST API and returning associative arrays. There are probably a lot of things we could extend to improve user experience, but for now, this should work. In particular, the API's alert features are pretty lacking, and I would like to improve the ability to query for specific stations and the like, but as is, it's just a giant list of problems that the end-user code has to wade through. Sorry. 

Also, sorry it's in PHP. I was too busy getting things done to learn a new language ;-) 

Information on the API can be found on the MBTA Developer site: 
http://realtime.mbta.com/Portal/Home/Documents

Also useful is the knowledge that the MBTA API abides by the [GTFS](https://developers.google.com/transit/gtfs/reference), which is why, for instance, the Green line and  Red Line Mattapan high speed trollies are both route type 0, but all other T service is type 1, but both have the label "Subway" - Google specifies trams, streetcars, and light rail be type 0. 

Please don't use the provided sample API key. Also, note that the MBTA may change
the sample API key at any time, so check the dev site to make sure that you 
have the most recent version. 
