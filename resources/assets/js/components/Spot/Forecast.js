import React, {Component, Fragment} from 'react';

class Forecast extends Component{
    constructor(props){
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
            <h1>Forecast</h1>
        )
    }
}

export default Forecast;