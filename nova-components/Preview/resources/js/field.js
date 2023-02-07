import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-preview', IndexField)
  app.component('detail-preview', DetailField)
  app.component('form-preview', FormField)
})
