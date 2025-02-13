document.addEventListener('DOMContentLoaded', function() {
    // Handle active menu items
    const menuItems = document.querySelectorAll('.sidebar-link');
    const currentPath = window.location.search;

    menuItems.forEach(item => {
        if (item.getAttribute('href').includes(currentPath)) {
            item.classList.add('active');
        }

        item.addEventListener('click', function(e) {
            menuItems.forEach(mi => mi.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Handle table checkboxes
    Joomla.checkAll = function(checkbox) {
        const items = document.getElementsByName(checkbox.name.replace('toggle', ''));
        items.forEach(item => {
            item.checked = checkbox.checked;
        });
    };

    // Handle batch operations
    Joomla.submitbutton = function(task) {
        if (task === '') {
            return false;
        }
        
        if (task === 'items.delete' && !confirm(Joomla.Text._('COM_FIXASSETS_CONFIRM_DELETE'))) {
            return false;
        }
        
        Joomla.submitform(task);
        return true;
    };

    // Handle filters
    const filterForm = document.getElementById('adminForm');
    if (filterForm) {
        const filterInputs = filterForm.querySelectorAll('.js-stools-field-filter select, .js-stools-field-filter input');
        filterInputs.forEach(input => {
            input.addEventListener('change', function() {
                filterForm.submit();
            });
        });
    }
});