import React, {Component} from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

class EditItem extends Component {
    constructor(props) {
        super(props);
        this.state = {name: '', parent_id: ''};
        this.handleChange1 = this.handleChange1.bind(this);
        this.handleChange2 = this.handleChange2.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    componentDidMount(){
        axios.get(`/api/categories/${this.props.match.params.id}/edit`)
            .then(response => {
                this.setState({ name: response.data.data.name, parent_id: response.data.data.parent_id });
            })
            .catch(function (error) {
                console.log(error);
            })
    }
    handleChange1(e){
        this.setState({
            name: e.target.value
        })
    }
    handleChange2(e){
        this.setState({
            parent_id: e.target.value
        })
    }

    handleSubmit(event) {
        event.preventDefault();
        const categories = {
            name: this.state.name,
            parent_id: this.state.parent_id
        }
        let uri = '/api/categories/'+this.props.match.params.id;
        axios.patch(uri, categories).then((response) => {
            this.props.push('/display-item');
        });
    }
    render(){
        return (
            <div>
                <h1>Update Item</h1>
                <div className="row">
                    <div className="col-md-10"></div>
                    <div className="col-md-2">
                        <Link to="/display-item" className="btn btn-success">Return to Category</Link>
                    </div>
                </div>
                <form onSubmit={this.handleSubmit}>
                    <div className="form-group">
                        <label>Category Name</label>
                        <input type="text"
                               className="form-control"
                               value={this.state.name}
                               onChange={this.handleChange1} />
                    </div>

                    <div className="form-group">
                        <label name="parent_id">Category Parent ID</label>
                        <input type="text" className="form-control"
                               value={this.state.parent_id}
                               onChange={this.handleChange2} />
                    </div>

                    <div className="form-group">
                        <button className="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        )
    }
}
export default EditItem;
