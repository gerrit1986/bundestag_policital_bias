# -*- coding: utf-8 -*-
# !/usr/bin/python2.7

# This script calculates the central tendency of word frequencies and their 
# standard deviation. Upon, it defines upper threshold and lower threshold for 
# detection of more or less occurrences of terms and analyzes whether certain 
# terms were more or less used by a certain faction.

__author__ = "Gerrit Holz"
__date__ = "11.07.2012"

# import modules
import math
import itertools
import csv

# import own class
import UnicodeWriter

# number of words per faction, counted with wordcount.php
w_cdu = 2381961.0
w_spd = 1937188.0
w_fdp = 1155568.0
w_gruene = 1120902.0
w_linke = 1081327.0

# read ids, terms, factions and frequency into data structures and create data
list_ids = [x[0] for x in csv.reader(open('input.csv','r'))]
list_terms = [x[1] for x in csv.reader(open('input.csv','r'))]
list_factions = [x[2] for x in csv.reader(open('input.csv','r'))]
list_occ = [x[3] for x in csv.reader(open('input.csv','r'))]
data = zip(list_ids, list_terms, list_factions, list_occ)

# (re)set counter's values
count_upp = 0
count_low = 0

# open csv file before work starts
UnicodeWriter = open('output.csv','w')

# start loop which increments by 5 for analysis of a set
x = 0
for x in range(0,9996,5):

    # tupel and value for cdu
    tupel1 = data[0 + x]
    occ1 = int(tupel1[3])

    # tupel and value for spd
    tupel2 = data[1 + x]
    occ2 = int(tupel2[3])

    # tupel and value for fdp
    tupel3 = data[2 + x]
    occ3 = int(tupel3[3])

    # tupel and value for gruene
    tupel4 = data[3 + x]
    occ4 = int(tupel4[3])

    # tupel and value for linke
    tupel5 = data[4 + x]
    occ5 = int(tupel5[3])

    # calculate term frequency for each faction
    freq1 = occ1 / w_cdu
    freq2 = occ2 / w_spd
    freq3 = occ3 / w_fdp
    freq4 = occ4 / w_gruene
    freq5 = occ5 / w_linke
    
    # values = [0, 0, 0, 0, 0]
    values = [freq1, freq2, freq3, freq4, freq5]

    # calculate mean
    def average(values): return sum(values) / 5.0
    mean = average(values)

    # calculate variance
    variance = map(lambda x: (x - mean) ** 2, values)

    # calculate stdev
    stdev = math.sqrt(average(variance))

    # calculate thresholds
    upp_thr = (mean + (1.0 * stdev))
    low_thr = (mean - (1.0 * stdev))
    
    # analyze whether a term is more or less used. if so, print results
    for i in range(len(values)):
        if values[i] > upp_thr:
            upp_outlier_faction = list_factions[i + x]
            upp_outlier_term = list_terms[i + x]
            print "A faction uses a term more:"
            print "Faction: " + upp_outlier_faction
            print "Term: " + upp_outlier_term
            print "Mean: " + str(mean)
            print "Standard Deviation: " + str(stdev)
            print "Upper Threshold: " + str(upp_thr)
            print "Value: " + str(values[i])
            print "---------------------------------------"
            count_upp = count_upp + 1
            
            # write values to csv-file after detection of value above upper threshold
            line = str(upp_outlier_faction) + ',' + str(upp_outlier_term) + ',' + str(values[i]) + ',' + str(mean) + ',' + str(stdev) + ',' + "more" + '\n'
            UnicodeWriter.write(line)
    
        if values[i] < low_thr:
            low_outlier_faction = list_factions[i + x]
            low_outlier_term = list_terms[i + x]
            print "A faction uses a term less:"
            print "Faction: " + low_outlier_faction
            print "Term: " + low_outlier_term
            print "Mean: " + str(mean)
            print "Standard Deviation: " + str(stdev)
            print "Lower Threshold: " + str(low_thr)
            print "Value: " + str(values[i]) 
            print "---------------------------------------"
            count_low = count_low + 1
            
            # write values to csv-file after detection of value below lower threshold
            line = str(low_outlier_faction) + ',' + str(low_outlier_term) + ',' + str(values[i]) + ',' + str(mean) + ',' + str(stdev) + ',' + "less" + '\n'
            UnicodeWriter.write(line)

# close csv writer after work
UnicodeWriter.close

# print counter's values to screen
print str(count_upp) + " Terms are more used" 
print str(count_low) + " Terms are less used"