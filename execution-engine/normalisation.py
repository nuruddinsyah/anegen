# ------------------------------------------------------------
#  Anegen - Web Service untuk Analisis Ekspresi Gen
# ------------------------------------------------------------
#  Oleh: Muhammad Faruq Nuruddinsyah
#  Copyright 2017. All Rights Reserved.
# ------------------------------------------------------------
#  Execution Engine: Normalisation
# ------------------------------------------------------------

import sys; sys.stderr = sys.stdout
import getopt
import GEOparse
import numpy as np
import pandas as pd
from sklearn import preprocessing

def main(argv):
    # Get input arguments

    filename = ''
    method = ''

    try:
        opts, args = getopt.getopt(argv, "", ["filename=", "method="])
    except getopt.GetoptError:
        print 'error!'
        sys.exit(2)

    for opt, arg in opts:
        if opt in ("--filename"):
            filename = arg
        elif opt in ("--method"):
            method = arg


    gse = GEOparse.GEOparse.parse_GSE(filepath = '/Applications/XAMPP/htdocs/bioinformatics/data-store/' + filename)
    sample = gse.pivot_samples('VALUE')
    sample_array = sample.as_matrix()

    np.savetxt('/Applications/XAMPP/htdocs/bioinformatics/data-store/sample.csv', sample_array, delimiter = ',')


    # Normalisation

    normalised_sample = preprocessing.normalize(sample, norm = method)
    
    #sample.to_csv('/Applications/XAMPP/htdocs/bioinformatics/data-store/' + filename + '.sample', sep = ',')
    np.savetxt('/Applications/XAMPP/htdocs/bioinformatics/data-store/' + filename + '.normalised', normalised_sample, delimiter = ',')
    
    print('ok')

if __name__ == "__main__":
    main(sys.argv[1:])
