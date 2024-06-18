import "./App.css";
import Todo from "./components/Todo";
import { QueryClient, QueryClientProvider } from "react-query";
import EditTodo from "./components/EditTodo";
import { BrowserRouter, Route, Routes } from "react-router-dom";

function App() {
  const queryClient = new QueryClient();
  return (
    <QueryClientProvider client={queryClient}>
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Todo />} />
          <Route path="/edit-todo/:id" element={<EditTodo />} />
        </Routes>
      </BrowserRouter>
    </QueryClientProvider>
  );
}

export default App;
