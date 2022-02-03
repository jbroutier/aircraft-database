import TomSelect from 'tom-select'

export function initSelect (parent) {
  parent.querySelectorAll('select').forEach(element => {
    const choices = new TomSelect(element, {
      render: {
        item: data => '<div>' + data.text + '</div>',
        option: data => '<div>' + data.text + '</div>'
      }
    })
    choices.enable()
  })
}
