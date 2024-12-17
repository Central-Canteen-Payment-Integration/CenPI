/**
 * @param {string} title - Title of the alert.
 * @param {string} icon - Type of alert (success, error, warning, info, question).
 * @param {Object} options - Additional Swal options (optional).
 */
function swalert(icon, title, options = {}) {
    const defaultOptions = {
        title: title,
        icon: icon,
        position: 'bottom-start', // Set position to bottom left
        toast: true,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    };
    const swalOptions = { ...defaultOptions, ...options };

    return Swal.fire(swalOptions);
}