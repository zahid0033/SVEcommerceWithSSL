import React, { Component } from 'react';

export default class Navbar extends Component {
    constructor(props) {
        super();
        this.name = props.name;
        this.state = {
            age : props.initialAge,
            state : 0
        }
    }
    onClickCount(){
        this.setState({
            age : this.state.age + 3
        });
    }

    render() {
        return (
            // navbar
            <div className="container">
                <div className="row justify-content-center">
                    <h1>Navbar {this.state.age}</h1>
                    <button onClick={() => this.onClickCount()} className="btn btn-danger">Count</button>
                    <p>Object name {this.props.user.name}</p>
                    <div>
                        <h4>Hobbies</h4>
                        <div>
                            {this.props.user.hobbies.map((hobby,i) =>
                                <p key = {i}>{hobby}</p>
                            )}
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-6">Hello</div>
                        <div className="col-md-6">world</div>
                    </div>
                </div>
            </div>
        );
    }
}
