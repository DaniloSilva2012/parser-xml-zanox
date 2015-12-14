(function(doc, win){
    
    function showLightBox(lightBoxDescription, lightBoxTitle, lightBoxHeading, lightBoxSubHeading){
        //heading
        //subheading
        //description
        //title
        var elLightBox = document.getElementById('lightbox-zanox'),
            elLightBoxOpacity = document.getElementById('lightbox-zanox-opacity');

        elLightBox.querySelector('.heading').textContent= lightBoxHeading;
        elLightBox.querySelector('.sub-heading').textContent= lightBoxHeading;
        elLightBox.querySelector('.description').textContent= lightBoxSubHeading;
        elLightBox.querySelector('.inputCode').value = lightBoxTitle;
        elLightBox.querySelector('.copy button').setAttribute('data-clipboard-text', lightBoxTitle);
        
        elLightBoxOpacity.style.display = 'block';
        elLightBox.style.display = 'block';
    }
    
    function hideLightBox(){
        var elLightBox = document.getElementById('lightbox-zanox'),
            elLightBoxOpacity = document.getElementById('lightbox-zanox-opacity');
        
        elLightBox.style.display = 'none';
        elLightBoxOpacity.style.display = 'none';
    }
    
    document.getElementById('lightbox-zanox-opacity').addEventListener('click', function(){
        hideLightBox();
    }, false);

    
    [].forEach.call(doc.getElementsByClassName('botao-cupom'), function(el){
        el.addEventListener('click', function(){
            var lightBoxDescription = this.getAttribute('data-description'),
                lightBoxTitle = this.getAttribute('data-title'),
                lightBoxHeading = this.getAttribute('data-heading'),
                lightBoxSubHeading = this.getAttribute('data-subheading'); 
        
            showLightBox(lightBoxDescription, lightBoxTitle, lightBoxHeading, lightBoxSubHeading);
            
        }, false);
    });
    
    [].forEach.call(doc.getElementsByClassName('info-cupom'), function(el){
        el.addEventListener('click', function(){
            var spanEl = this.nextSibling;
            //console.log('spanEl ' + spanEl);
            if(spanEl.getAttribute('class').indexOf('more-information-hide') !== -1){
                spanEl.setAttribute('class', spanEl.getAttribute('class').replace('more-information-show','').replace('more-information-hide',''));
                spanEl.setAttribute('class', spanEl.getAttribute('class').trim() + ' more-information-show');            
            } else {
                spanEl.setAttribute('class', spanEl.getAttribute('class').replace('more-information-show','').replace('more-information-hide',''));
                spanEl.setAttribute('class', spanEl.getAttribute('class').trim() + ' more-information-hide');            
            }
        }, false);
    });
    
    
    
})(document,window);