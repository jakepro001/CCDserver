###############################
# Gray Scale
# Median Filter
# Smoothening
# Edge Detection
# 
# Image binarisation
#
# Image Segmentation
#
# Feature Extraction
#
################################


from skimage import data, io, filters
from skimage.color import rgb2gray 
from skimage.morphology import disk
from skimage.filters.rank import median
from skimage import feature
from skimage import filters
from skimage import segmentation
import numpy as np


def imageprocess(image_path):

	# Reading Image
	img = io.imread(image_path)

	# Converting to grayscale
	img_grayscale = rgb2gray(img)

	# saving to gray
	io.imsave('uploads/imgray.jpg',img_grayscale)

	#sobel filter
	edges = filters.sobel(img_grayscale)

	io.imsave('uploads/imgfil.jpg',img_grayscale)

	#median filter
	med = median(img_grayscale, disk(5))

	io.imsave('uploads/imgmed.jpg',med)

	# edge detection
	edges2 = feature.canny(img_grayscale)

	#edges2 = feature.canny(img_grayscale, sigma=1)

	#io.imsave('uploads/imgedge.jpg',edges2)

	
	#binarization
	val = filters.threshold_otsu(img_grayscale)
	mask = img_grayscale < val

	io.imsave('uploads/imgbin.jpg',img_grayscale)

	mask = img_grayscale > filters.threshold_otsu(img_grayscale)
	clean_border = segmentation.clear_border(mask)
	#segmentation
	coins_edges = segmentation.mark_boundaries(img_grayscale, clean_border.astype(np.int))

	io.imsave('uploads/imgseg.jpg',coins_edges)
