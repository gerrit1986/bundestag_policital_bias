## Introduction ##

The purpose of this word frequency analysis is to serve as a preparation for the detection of political bias on Wikipedia in German. Therefore, parliamentary minutes from the German Bundestag have been indexed and words have been counted to determine word frequencies with respect to the five factions. The basic question is: "Which terms are used by a certain faction significantly more or less?" An answer is given in `output.csv`. The numbers are compared based upon the calculated standard deviation. In the future, Wikipedia's articles will be scanned for the occurrences of words that are used by a certain faction more or less.

## Overview ##

What follows is a brief overview over the published resources. Everything is encoded in UTF-8. Opening the `csv` files with Open-/Libre Office is suggested.

The data for analysis is:

* Parliamentary minutes from the German Bundestag over a period of ~1,5 years (currently not in repo): `speeches.csv` [~200 MB]
* 5000 basic forms of most frequent terms from the minutes: `terms.txt` [~50 KB]
* Term, faction and number of occurrences of terms from the minutes: `input.csv` [~300 KB]
* List of factions in the German Bundestag: `factions.txt` [~50 B]
* Stopword list applied while indexing (currently not in repo): `stopwords.txt` [~15 KB]

The scripts for evaluation are:

* Check terms in corpus: `political_bias_check.php`
* Word frequency analysis: `analysis.py`
* Wordcount: `wordcount.php`

The results can be found here:

* Output of the analysis: `output.csv` [~300 KB]
* Results of counting: `results.csv` [~600 KB]

## Acknowledgments ##

* This work was largely inspired by the following research paper: Shane Greenstein and Feng Zhu (2012): "Is Wikipedia Biased?"
* Many thanks to the Open Knowledge Foundation Deutschland for crawling the minutes.
* Many thanks to [Norman Rosner](http://rosner.io/) for helping us with the Solr setup for indexing.

## License ##

"bundestag_political_bias" is published under a BSD License.
Copyright © 2012, Wikimedia Deutschland (Gerrit Holz)
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:
    * Redistributions of source code must retain the above copyright
    notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright
    notice, this list of conditions and the following disclaimer in the
    documentation and/or other materials provided with the distribution.
    * Neither the name of Wikimedia Deutschland nor the names of its 
    contributors may be used to endorse or promote products derived from 
    this software without specific prior written permission.
THIS SOFTWARE IS PROVIDED BY WIKIMEDIA DEUTSCHLAND ''AS IS'' AND ANY 
EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED 
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE 
DISCLAIMED. IN NO EVENT SHALL WIKIMEDIA DEUTSCHLAND BE LIABLE FOR AND 
DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES 
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; 
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND 
ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT 
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS 
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

### Disclaimer ###

NOTE: This software is not released as a product. It was written primarily for
Wikimedia Deutschland's own use, and is made public as is, in the hope it may
be useful. Wikimedia Deutschland may at any time discontinue developing or
supporting this software. There is no guarantee any new versions or even fixes
for security issues will be released.
