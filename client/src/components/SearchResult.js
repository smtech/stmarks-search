import React, {Component} from 'react';
import {Tooltip, OverlayTrigger, Image, Label} from 'react-bootstrap';

export default class SearchResult extends Component {
    render() {
        var tooltip = <Tooltip id={this.props.result.hash + '-tooltip'}>{this.props.result.relevance.rationale.split(',').join('\n')}</Tooltip>;
        return (
            <tr>
                <td>
                    <p>
                        <a href={this.props.result.url}><span dangerouslySetInnerHTML={{__html: this.props.result.title}} /></a> <OverlayTrigger placement="bottom" overlay={tooltip}>
                            <Label className="rationale">{this.props.result.relevance.score}</Label>
                        </OverlayTrigger>
                        <span className="pull-right">
                            <a href={this.props.result['source']['url']}>
                                from <Image src={this.props.result.source.icon} className="domain-icon" /> {this.props.result.source.name}
                            </a>
                        </span>
                    </p>
                    <p dangerouslySetInnerHTML={{__html: this.props.result.description}} />
                </td>
            </tr>
        );
    }
}