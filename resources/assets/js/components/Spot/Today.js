import React, {Component, Fragment} from 'react';

class Today extends Component{
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
            <h2>Report for {this.state.data.date}</h2>
        )
    }
}

export default Today;