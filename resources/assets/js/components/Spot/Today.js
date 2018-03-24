import React, {Component, Fragment} from 'react';

class Today extends Component{
    constructor(props) {
        super(props)
        this.state = {
            data: []
        }
    }

    componentWillReceiveProps(nextProps){
        this.setState({
            data: nextProps
        })
    }

    render(){
        return(
            <h1>Today</h1>
        )
    }
}

export default Today;