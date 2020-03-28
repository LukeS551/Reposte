function postScript() {
    if (tour) {
        const driver = new Driver();
        driver.highlight({
            element: '.full',
            popover: {
                title: '<div class="card-title">Welcome!<div>',
                description: 'This is the start of our tour',
                position: 'bottom',
            }
        });

    }

}