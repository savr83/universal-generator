import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class Example extends Component {
    componentDidMount() {
    }
    render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">Example Component</div>
                            <div className="card-body">I'm an example component!</div>
                            <button type="button" data-toggle="popover" data-placement="left" data-content="test lalala">Test</button>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Example;

if (document.getElementById('root')) {
    ReactDOM.render(<Example />, document.getElementById('root'));
}
