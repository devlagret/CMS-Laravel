import { jsxs, jsx } from "react/jsx-runtime";
import { Link } from "@inertiajs/react";
function Guest({ children }) {
  return /* @__PURE__ */ jsxs("div", { className: "flex bg-splash3 min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0 dark:bg-gray-900", children: [
    /* @__PURE__ */ jsx("div", { children: /* @__PURE__ */ jsx(Link, { href: "/", children: /* @__PURE__ */ jsx(
      "img",
      {
        src: "resources\\assets\\img\\icon.png",
        className: "img-fluid rounded-top h-20 w-20"
      }
    ) }) }),
    /* @__PURE__ */ jsx("div", { className: "mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg dark:bg-gray-800", children })
  ] });
}
export {
  Guest as G
};
