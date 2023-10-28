class Request {
    constructor(name, email, phone, price) {
        this.submitForm(name, email, phone, price);
    }
    submitForm(name, email, phone, price) {
        const formData = {
            name: name,
            email: email,
            phone: phone,
            price: price
        }

        fetch('https://b98e-95-181-242-237.ngrok-free.app/api/form', {
            method: 'POST',
            mode: "cors",
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Server or Network error');
                }
                console.log(response());
            })
            .catch(error => {
                console.log(error);
            })

    }
}