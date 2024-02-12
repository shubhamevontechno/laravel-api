import React from "react";
import ReactDOM from 'react-dom/client';

const FormComponent = () => {
    return (
        <>
        <h2>Form</h2>
            <form method="POST" id="form-data">
                <div class="mb-3 mt-3">
                    <label htmlFor="name">Name:</label>
                    <input type="text" className="form-control" id="name" placeholder="Enter name" name="name" />
                </div>
                <div class="mb-3">
                    <label htmlFor="email">Email:</label>
                    <input type="email" className="form-control" id="email" placeholder="Enter email" name="email" />
                </div>
                <button type="submit" class="btn btn-primary submit-form" id="create_new">Next Step </button>
            </form>
        </>
    )

}
export default FormComponent

if (document.getElementById('FormComponent')) {
    const Index = ReactDOM.createRoot(document.getElementById("FormComponent"));

    Index.render(
        <React.StrictMode>
            <FormComponent/>
        </React.StrictMode>
    )
}
