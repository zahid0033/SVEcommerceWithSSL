import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Header from './header';
import Footer from './footer';
import Navbar from './navbar';

export default class Example extends Component {
    render() {
        var user = {
            name :"Hashib",
            hobbies : ["sports","Cricket","Football","Baseball"]
        };
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <Header/>

                        <div className="card">
                            <div className="card-header">Example Component</div>
                            <div className="card-body">
                                <Navbar name={"Zahid"} initialAge={30} user ={user} />
                            </div>
                        </div>
                        <Footer/>
                    </div>
                </div>
            </div>
        );
    }
}

if (document.getElementById('example')) {
    ReactDOM.render(<Example />, document.getElementById('example'));
}
