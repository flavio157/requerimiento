BrowserCodeReader.prototype.createBinaryBitmap = function (mediaElement) {
    if (undefined === this.canvasElementContext) {
        this.prepareCaptureCanvas();
    }
    this.canvasElementContext.drawImage(mediaElement, 0, 0);
    // FIXME byHo
    // var luminanceSource = new HTMLCanvasElementLuminanceSource(this.canvasElement);
    // var hybridBinarizer = new HybridBinarizer(luminanceSource);
    // return new BinaryBitmap(hybridBinarizer); 
    
    const allWidth = this.canvasElement.width;
    const allHeight = this.canvasElement.height;
    const left = allWidth/4;
    const top = Math.min(allWidth, allHeight)/4;
    const squareSize = Math.min(allWidth, allHeight) / 2;
    // const crop = all.crop(left, top, squareSize, squareSize);
    console.log(allWidth +","+ allHeight);

    var canvas1 = document.createElement("canvas");
    canvas1.width = squareSize;
    canvas1.height = squareSize;
    var ctx1 = canvas1.getContext("2d");
    ctx1.rect(0, 0, squareSize, squareSize);
    ctx1.fillStyle = 'white';
    ctx1.fill();
    // ctx1.putImageData(crop.binarizer.source, 0, 0);
    ctx1.putImageData(
        this.canvasElementContext.getImageData(left, top, squareSize, squareSize), 
        0, 0);

    $('.dstImg').attr('src', canvas1.toDataURL("image/png"));
    // $('.dstImg').each((i, img) => 
    //     this.canvasElementContext.drawImage(img, left, top, squareSize, squareSize, 0, 0, squareSize, squareSize));

    var luminanceSource = new HTMLCanvasElementLuminanceSource(canvas1);
    var hybridBinarizer = new HybridBinarizer(luminanceSource);

    // hybridBinarizer.source.buffer = crop.binarizer.source;
    // hybridBinarizer.source.width = squareSize;
    // hybridBinarizer.source.height = squareSize;
    return new BinaryBitmap(hybridBinarizer);
};