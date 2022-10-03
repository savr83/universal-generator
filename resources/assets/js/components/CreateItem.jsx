import React, {Component} from 'react';
import axios from 'axios';

class CreateItem extends Component {
    constructor(props){
        super(props);
        this.state = {CategoryName: '', ParentID: ''};

        this.handleChange1 = this.handleChange1.bind(this);
        this.handleChange2 = this.handleChange2.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }
    handleChange1(e){
        this.setState({
            CategoryName: e.target.value
        })
    }
    handleChange2(e){
        this.setState({
            ParentID: e.target.value
        })
    }
    handleSubmit(e){
        e.preventDefault();
        const categories = {
            name: this.state.CategoryName,
            parent_id: this.state.ParentID
        }
        let uri = '/api/categories/';
        axios.post(uri, categories).then((response) => {
            // browserHistory.push('/display-item');
            console.log(response);
        });
    }
    render() {
        return (
            <div>
                <h1>Create An Category</h1>
                <form onSubmit={this.handleSubmit}>
                    <div className="row">
                        <div className="col-md-6">
                            <div className="form-group">
                                <label>Category Name:</label>
                                <input type="text" className="form-control" onChange={this.handleChange1} />
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-6">
                            <div className="form-group">
                                <label>Parent ID:</label>
                                <input type="text" className="form-control col-md-6" onChange={this.handleChange2} />
                            </div>
                        </div>
                    </div><br />
                    <div className="form-group">
                        <button className="btn btn-primary">Add Category</button>
                    </div>
                </form>
            </div>
        )
    }
}
export default CreateItem;
