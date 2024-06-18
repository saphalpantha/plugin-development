import React, { useEffect } from "react";
import classes from "./Todo.module.css";
import { useQuery } from "react-query";
import { useForm } from "react-hook-form";
import { useParams } from "react-router-dom";
import axios from "axios";
import { useNavigate } from "react-router-dom";
const Todo = () => {
  const { register, handleSubmit, setValue } = useForm();

  const { id } = useParams();

  const navigate = useNavigate();
  const fetchTodoById = async () => {
    const res = await fetch(
      `http://localhost/plugin-development/third-day/api/server.php?id=${id}`
    );
    if (!res.ok) {
      throw new Error("Network response was not ok");
    }
    return res.json();
  };

  const submitHandler = async (userInput) => {
    try {
      const res = await axios.put(
        "http://localhost/plugin-development/third-day/api/server.php",
        { title: userInput.title, status: userInput.status, id: id }
      );


      console.log(res.data)
      if (res.status !== 200) {
        throw new Error("Failed to Connect");
      }
      
      
      alert(`${res.data.message}`);
      navigate(`/`);
    } catch (error) {
      console.error("Error:", error);
      alert("An error occurred while submitting the form.");
    }
  };

  const { data } = useQuery("singletodo", fetchTodoById, {
    onSuccess: (data) => {
      const todo = data.data[0];
      setValue("title", todo.title);
      setValue("status", todo.status);
    },
  });

  useEffect(() => {
    if (data) {
      const todo = data.data[0];
      setValue("title", todo.title);
      setValue("status", todo.status);
    }
  }, [data, setValue]);

  return (
    <div className={classes.main}>
      <form onSubmit={handleSubmit(submitHandler)}>
        <input {...register("title")} placeholder="What do you need to do?" />
        <select {...register("status")}>
          <option value="pending">Pending</option>
          <option value="completed">Completed</option>
        </select>
        <button type="submit">Add</button>
      </form>
    </div>
  );
};

export default Todo;
