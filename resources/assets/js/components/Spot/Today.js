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
            <h1>Today</h1>
        )
    }
}

export default Today;