// Import the Menu component
import Menu from '../components/Menu';

function Dashboard() {
  return (
    <div className="flex">
      {/* Menu */}
      <Menu />
      {/* Content */}
      <div className="w-3/4 p-5">
        Content goes here.
      </div>
    </div>
  );
}

ReactDOM.render(
  <Dashboard />,
  document.getElementById('root')
);