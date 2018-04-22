import React, { Component } from 'react';
import Autocomplete from 'react-autocomplete';
import ReactDOM from "react-dom";


class Searchbox extends Component{
    constructor(props){
        super(props)
        this.state = {
            spots: JSON.parse(this.props.spots),
            value: ''
        }

        this.formatSpots = this.formatSpots.bind(this);
    }

    formatSpots(aSpots){
        let arr = []
        aSpots.forEach((spot) => {
            let obj = {}
            obj.label = spot['name']
            obj.link = window.location.origin + '/' + spot['link']
            arr.push(obj)
        })
        return arr
    }

    render(){
        return(
            <Autocomplete
                items={this.formatSpots(JSON.parse(this.props.spots))}
                shouldItemRender={(item, value) => item.label.toLowerCase().indexOf(value.toLowerCase()) > -1}
                getItemValue={(item) => item.label}
                renderItem={(item, isHighlighted) =>
                    <div className="searchItems" style={{ background: isHighlighted ? 'lightgray' : 'white' }} key={item.label}>
                        <a href={item.link}>{item.label}</a>
                    </div>
                }
                value={this.state.value}
                onChange={e => this.setState({ value: e.target.value })}
                onSelect={(value, item) => {
                    this.setState({ value })
                    const url = item.link
                    window.location = url
                }}
                inputProps={
                    {
                        placeholder: 'search spots',
                        style: {
                            borderRadius: '5px',
                            padding: '5px'
                        }
                    }
                }
            />
        )
    }
}

if (document.getElementById('searchBox') || document.getElementById('searchBoxMobile')) {
    const element = document.getElementById('searchBox')
    const elementMobile = document.getElementById('searchBoxMobile')
    const props = Object.assign({}, element.dataset)
    const propsMobile = Object.assign({}, elementMobile.dataset)
    ReactDOM.render(<Searchbox {...props} />, document.getElementById('searchBox'))
    ReactDOM.render(<Searchbox {...propsMobile} />, document.getElementById('searchBoxMobile'))
}