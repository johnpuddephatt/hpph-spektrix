import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-svg', IndexField)
  app.component('detail-svg', DetailField)
  app.component('form-svg', FormField)
})
