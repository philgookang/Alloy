
class Hello extends React.Component {
  render() {
    return (
        <div>
            <center>
                <div className="happy">
                    {this.props.data.happy}
                </div>
            </center>
            <div className="name">
                {this.props.data.name}
            </div>
        </div>
    );
  }
}
