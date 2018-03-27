import React, {Component, Fragment} from 'react';

class Reviews extends Component{
    constructor(props) {
        super(props)
        this.state = {
            data: {}
        }
    }

    componentWillMount(){
        this.setState({
            data: this.props.state
        })
    }

    render(){
        return(
            <h1>Reviews</h1>
        )
    }
}

export default Reviews;