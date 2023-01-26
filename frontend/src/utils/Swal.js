import Vue from 'vue'

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css'

const timer = 2000

/**
 *
 * @param title
 * @param desc
 */
const alertSuccess = (title = '$TITLE_SUCCESS', desc = '$DESC_SUCCESS') => {
  Vue.swal.fire({
    icon: 'success',
    text: desc,
    timer,
    title,
  })
}

/**
 *
 * @param title
 * @param desc
 */
const alertError = (title = '$TITLE_ERROR', desc = '$DESC_ERROR') => {
  Vue.swal.fire({
    icon: 'error',
    text: desc,
    timer,
    title,
  })
}

const alertInfo = (title = '$TITLE_INFO', desc = '$DESC_INFO') => {
  Vue.swal.fire({
    allowOutsideClick: false,
    cancelButtonColor: '#19B5FE',
    cancelButtonText: 'OK',
    close,
    icon: 'info',
    showCancelButton: true,
    showConfirmButton: false,
    text: desc,
    title,
  })
}

const alertConfirmDelete = async (title = null, desc = null) => {
  title = title === null ? 'Are You Sure Want Delete ?' : title
  desc = desc === null ? 'Listen This Be Carefully' : desc
  const confirmAlert = await Vue.swal.fire({
    allowOutsideClick: false,
    color: '#C91F37',
    confirmButtonColor: '#C91F37',
    confirmButtonText: 'DELETE',
    denyButtonColor: '#BFBFBF',
    denyButtonText: 'NO',
    icon: 'warning',
    iconColor: '#C91F37',
    showConfirmButton: true,
    showDenyButton: true,
    text: desc,
    title,
  })
  return confirmAlert?.value
}

const alertConfirmPrint = async (title = null, desc = null) => {
  title = title === null ? 'Are You Sure Want Delete ?' : title
  desc = desc === null ? 'Listen This Be Carefully' : desc
  const confirmAlert = await Vue.swal.fire({
    allowOutsideClick: false,
    color: '#FEDE00',
    confirmButtonColor: '#FEDE00',
    confirmButtonText: 'PRINT',
    denyButtonColor: '#BFBFBF',
    denyButtonText: 'NO',
    icon: 'warning',
    iconColor: '#FEDE00',
    showConfirmButton: true,
    showDenyButton: true,
    text: desc,
    title,
  })
  return confirmAlert?.value
}

const alertSuccessDelete = (title = 'Success Delete') => {
  Vue.swal.fire({
    icon: 'success',
    iconColor: '#C91F37',
    color: '#C91F37',
    timer: 2000,
    allowOutsideClick: false,
    showCancelButton: false,
    showConfirmButton: false,
    padding: 100,
    title,
  })
}

/**
 *
 * @param title
 */
const toastSuccess = (title = 'Success Toast') => {
  const Toast = Vue.swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Vue.swal.stopTimer)
      toast.addEventListener('mouseleave', Vue.swal.resumeTimer)
      toast.addEventListener('click', Vue.swal.close)
    },
  })

  Toast.fire({
    icon: 'success',
    title,
  })
}

/**
 *
 * @param title
 */
const toastInfo = (title = 'Info Toast') => {
  const Toast = Vue.swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Vue.swal.stopTimer)
      toast.addEventListener('mouseleave', Vue.swal.resumeTimer)
      toast.addEventListener('click', Vue.swal.close)
    },
  })

  Toast.fire({
    icon: 'info',
    title,
  })
}

const Dialog = {
  alertConfirmPrint,
  alertConfirmDelete,
  alertError,
  alertInfo,
  alertSuccessDelete,
  alertSuccess,
  toastInfo,
  toastSuccess,
}

export default Dialog
