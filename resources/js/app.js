require('../css/app.css')
import Alpine from 'alpinejs'
import Intersect from '@alpinejs/intersect'
import focus from '@alpinejs/focus'
import mask from '@alpinejs/mask'

Alpine.plugin([focus,mask, Intersect])
Alpine.start()

// If you want Alpine's instance to be available everywhere.
window.Alpine = Alpine

