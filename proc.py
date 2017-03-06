import imageProcessing
import imageRecognition
import sys

image_path = sys.argv[1]

# Finding denominaiton
denom = imageRecognition.imagerecognize(image_path);

print denom

#process image
imageProcessing.imageprocess(image_path)



