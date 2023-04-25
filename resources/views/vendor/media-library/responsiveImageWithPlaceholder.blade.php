<img{!! $attributeString !!} @if ($loadingAttributeValue) loading="{{ $loadingAttributeValue }}" @endif
    srcset="{{ $media->getSrcset($conversion) }}"
    onload="window.requestAnimationFrame(function(){
        console.log('onload');
        if(dataset.width) {
            console.log('dataset.width:',dataset.width);
            onload = null; 
            sizes = dataset.width; 
        }
        else if(!(size=getBoundingClientRect().width)) {
            setTimeout(onload,500);
            return;
        } 
        else {
            onload=null;
            sizes=Math.ceil(size/window.innerWidth*100)+'vw';
        }
    })
        "
    sizes="1px" src="{{ $media->getUrl($conversion) }}" width="{{ $width }}" height="{{ $height }}">
