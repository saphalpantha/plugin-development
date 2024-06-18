import { QueryClient, QueryClientProvider } from "react-query";
import Employee from "./components/Employee";
import './App.css'
function App() {
  const queryClient = new QueryClient();

  return (
    <>
      <QueryClientProvider client={queryClient}>
        <Employee/>
      </QueryClientProvider>
    </>
  );
}

export default App;
