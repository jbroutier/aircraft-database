import { Tooltip } from 'bootstrap'

export function initTooltip (parent) {
  parent.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(element => {
    const tooltip = new Tooltip(element)
    tooltip.enable()
  })
}
