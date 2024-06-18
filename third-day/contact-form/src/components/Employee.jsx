import { useQuery, useMutation, useQueryClient } from "react-query";
import { useForm } from "react-hook-form";
function Employee() {
  const queryClient = useQueryClient();
  const fetchEmployee = async () => {
    const res = await fetch(
      "https://fakerestapi.azurewebsites.net/api/v1/Authors"
    );

    return res.json();
  };

  const { data, isLoading, error } = useQuery({
    queryKey: ["employees"],
    queryFn: fetchEmployee,
  });

  const {
    register,
    reset,
    handleSubmit,
    formState: { errors },
  } = useForm();
  //   console.log(info)

  const submitHandler = (userInput) => {
    
    const {idBook, id} = userInput;

    const updatedInput = {
        ...userInput,
        idBook:parseInt(idBook),
        id:parseInt(id)
    }

    console.log(updatedInput)

    // console.log(userInput)
    // reset();
    return fetch('https://fakerestapi.azurewebsites.net/api/v1/Authors', {
        method:'POST',
        headers:{
            'Content-Type':'text/json'
        },
        body:JSON.stringify(updatedInput)
    })
  };
  const {mutate, error:mutateErr, isLoading:isSubmitting, data:resData} = useMutation({
    mutationFn: (values) => submitHandler(values),
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["employees"] });
    },
  });


//   console.log(mutateErr, isSubmitting,resData,'faoisd');

  //   const {mutation , mutationAsync , isLoading , isError} = useMutation(postData);

//   console.log( "foiasdjfoisa");

  if(error){
    return <h1>{error?.message}</h1>
  }

  if(mutateErr){
    return alert(`${mutateErr.message}`);
  }

  return (
    <>
      <div style={{ width: "75vw" }}>
        <form
          onSubmit={handleSubmit(mutate)}
          style={{
            display: "flex",
            margin: "0 auto",
            flexDirection: "column",
            width: "500px",
            gap: "1rem",
          }}
        >
          <h1>Author Registration Form</h1>
          <input
          
            {...register("firstName", {
              required: "First Name cannot be empty",
            })}
            style={{ height: "2rem", paddingLeft: "0.2rem" }}
            placeholder="first Name"
          />

          {errors.firstName && (
            <p style={{ padding: "0.2rem auto", color: "lightpink" }}>
              {errors.firstName.message}
            </p>
          )}
          <input
            {...register("lastName", { required: "Last name cannot be empty" })}
            style={{ height: "2rem", paddingLeft: "0.2rem" }}
            placeholder="Last Name"
          />
          {errors.lastName && (
            <p style={{ padding: "0.2rem auto", color: "lightpink" }}>
              {errors.lastName.message}
            </p>
          )}
          <input
          type="number"
            {...register("idBook", { required: "Book id is required !" })}
            style={{ height: "2rem", paddingLeft: "0.2rem" }}
            placeholder="Book Id"
        
          />
          {errors.idBook && (
            <p style={{ padding: "0.2rem auto", color: "lightpink" }}>
              {errors.idBook.message}
            </p>
          )}

          <input
          type="number"
            {...register("id", { required: "Author Id cannot be empty !" })}
            style={{ height: "2rem", paddingLeft: "0.2rem" }}
            placeholder="Author Id"
          />
          {errors.id && (
            <p style={{ padding: "0.2rem auto", color: "lightpink" }}>
              {errors.id.message}
            </p>
          )}

          <button>{isSubmitting ? "Submitting"  : "Submit"}</button>
        </form>
        <table
          style={{
            margin: "0 auto",
            width: "100%",
            paddingTop: "4rem",
            justifyContent: "space-between",
          }}
        >
          <h2>Author Lists</h2>

          <tr>
            <th>id</th>
            <th>idBook</th>
            <th>first name</th>
            <th>last name</th>
          </tr>
          {isLoading ? (
            <h1>Loading..</h1>
          ) : data.length === 0 ? (
            <span>No Authors</span>
          ) : (
            data?.slice(0, 5)?.map((i) => (
              <tr>
                <td>{i.id}</td>
                <td>{i.idBook}</td>
                <td>{i.firstName}</td>
                <td>{i.lastName}</td>
              </tr>
            ))
          )}
        </table>
      </div>
    </>
  );
}

export default Employee;
