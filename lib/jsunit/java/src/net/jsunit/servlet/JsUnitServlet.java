package net.jsunit.servlet;

import net.jsunit.JsUnitServer;

import javax.servlet.http.HttpServlet;

public class JsUnitServlet extends HttpServlet {
    protected static JsUnitServer server;

    public static void setServer(JsUnitServer aServer) {
        server = aServer;
    }
}