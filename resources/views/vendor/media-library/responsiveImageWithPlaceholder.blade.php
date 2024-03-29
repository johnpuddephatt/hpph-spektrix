<img{!! $attributeString !!} @if ($loadingAttributeValue) loading="{{ $loadingAttributeValue }}" @endif
    srcset="{{ $media->getSrcset($conversion) }}"
    onload="window.requestAnimationFrame(function(){
        if(sizes !== '1px') return;
        
        if(dataset.width) {            
            sizes = dataset.width; 
        }
        else if(!(size=getBoundingClientRect().width)) {
            setTimeout(onload,500);
            return;
        } 
        else {
            
            sizes=Math.ceil(size/window.innerWidth*100)+'vw';
        }


    })
        "
    sizes="1px" src="{{ $media->getUrl($conversion) }}" width="{{ $width }}" height="{{ $height }}">
