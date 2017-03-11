package com.inventory.cis;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.graphics.Color;
import android.graphics.Typeface;
import android.graphics.drawable.ColorDrawable;
import android.os.AsyncTask;
import android.os.Bundle;
import android.text.InputType;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.Window;
import android.view.inputmethod.InputMethodManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gcm.GCMRegistrar;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.HttpVersion;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.params.HttpParams;
import org.apache.http.params.HttpProtocolParams;
import org.apache.http.protocol.HTTP;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.HashMap;


public class LoginActivity extends Activity implements OnClickListener {

	EditText et_email, et_pass;
	Button btn_login, btn_confirm;
	TextView txt_welcome, txt_title;
	public static String email, pass;
	String Response_code;
	String login_error, login_error_message, result;
	Typeface Set_font;
	SessionManager session;
	String user_id;
	HashMap<String, String> user;

	JSONObject jobj;





	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		try {

			setContentView(R.layout.userlogin);
			setContent();
			SetFont();
			clickeEvent();
		} catch (Exception e) {
			//e.printStackTrace();
		}


	}

	@Override
	public void onBackPressed() {
		moveTaskToBack(true);
		finish();
	}

	private void setContent() {
		// TODO Auto-generated method stub
		session = new SessionManager(getApplicationContext());
		user = session.getUserDetails();

		et_email = (EditText) findViewById(R.id.et_email);
		txt_welcome = (TextView) findViewById(R.id.txt_welcome);
		txt_title = (TextView) findViewById(R.id.txt_title);
		et_pass = (EditText) findViewById(R.id.et_pass);
		btn_login = (Button) findViewById(R.id.btn_login);
		btn_confirm = (Button) findViewById(R.id.btn_confirm);
		et_email.setInputType(InputType.TYPE_TEXT_VARIATION_EMAIL_ADDRESS);

		email = user.get(session.KEY_EMAIL);
		//pass = user.get(session.KEY_UserPassword);

		et_email.setText(email);
		//et_pass.setText(pass);
	}

	private void SetFont() {
		Set_font = Typeface.createFromAsset(
				getApplicationContext().getAssets(), "fonts/AGENCYR.TTF");
		Typeface Set_font_welcome = Typeface.createFromAsset(
				getApplicationContext().getAssets(), "fonts/AGENCYB.TTF");

		btn_login.setTypeface(Set_font);

		txt_welcome.setTypeface(Set_font_welcome);
		txt_title.setTypeface(Set_font);
		et_email.setTypeface(Set_font);
		et_pass.setTypeface(Set_font);
	}

	private void clickeEvent() {
		// TODO Auto-generated method stub
		btn_confirm.setOnClickListener(this);
		btn_login.setOnClickListener(this);

	}

	@Override
	public void onClick(View v) {
		// TODO Auto-generated method stub

		switch (v.getId()) {

		case R.id.btn_login:
			try {
				InputMethodManager inputManager = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);

				inputManager.hideSoftInputFromWindow(getCurrentFocus()
						.getWindowToken(), InputMethodManager.HIDE_NOT_ALWAYS);

                email = et_email.getText().toString().toLowerCase();
				pass = et_pass.getText().toString();
				//email = "admin";
				//pass = "admin";
				if (email.length() <= 0 || email.equals("")) {
					et_email.setError("Invalid Email");
				} else if (pass.length() <= 0 || pass.equals("")) {
					et_pass.setError("Invalid Password");
				} else {
					if (StaticData.isNetworkConnected(getApplicationContext())) {
						try {
							new LoginOperation().execute();
						} catch (Exception e) {
							//e.printStackTrace();
						}
					} else {
						Toast.makeText(getApplicationContext(),
								"Not connected to Internet", Toast.LENGTH_SHORT)
								.show();
					}
				}

			} catch (Exception e) {
				//e.printStackTrace();
			}
			break;
		case R.id.btn_confirm:

			Intent intent = new Intent(getApplicationContext(), ConfirmActivity.class);
			intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
			startActivity(intent);
			finish();

			break;

		}
	}

	private class LoginOperation extends AsyncTask<String, Void, Void> {

		Dialog pDialog = new Dialog(LoginActivity.this);

		protected void onPreExecute() {
			// Dialog.setMessage("Authanticating...");
			pDialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
			pDialog.getWindow().setBackgroundDrawable(
					new ColorDrawable(Color.TRANSPARENT));
			pDialog.setContentView(R.layout.custom_image_dialog);
			pDialog.show();
			pDialog.setCancelable(false);
		}

		// Call after onPreExecute method
		protected Void doInBackground(String... urls) {

			try {

				postData();

				Log.d("....", "...." + Response_code);

				jobj = new JSONObject(Response_code);
				login_error = jobj.getString("error");
				if (login_error.equals("true"))
					login_error_message = jobj.getString("error_msg");
				Log.d("Result", "...." + login_error);
				user_id = jobj.getString("user_id");





			} catch (JSONException e) {
				// TODO Auto-generated catch block
				//e.printStackTrace();
			} catch (NullPointerException n) {
				n.printStackTrace();
			}

			return null;
		}

		protected void onPostExecute(Void unused) {

			try {
				if (pDialog.isShowing())
					pDialog.dismiss();
				Login_result();
			} catch (Exception e) {
				// TODO: handle exception
				//e.printStackTrace();
			}

		}
	}

	@SuppressWarnings("deprecation")
	private void Login_result() {
		// TODO Auto-generated method stub

		if (login_error.equals("false")) {
			Log.w("Login Result..", "In:--" + login_error);
			try {

				Toast.makeText(getApplicationContext(),
						"Login Successfully...", Toast.LENGTH_SHORT).show();
				LoginCheck();
			} catch (Exception e) {
				//e.printStackTrace();
			}
		} else if (login_error.equals("true")) {

			Toast.makeText(getApplicationContext(), login_error_message
					, Toast.LENGTH_SHORT)
					.show();
		} else {
			Toast.makeText(getApplicationContext(),
					"your login failed try again...", Toast.LENGTH_SHORT)
					.show();

		}
	}

	private void LoginCheck() {
		if (login_error.equals("false")) {
			session.createLoginSession(user_id);
			session.registerUser(email, pass);
			Intent i = new Intent(LoginActivity.this, homeActivity.class);
			//i.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
			startActivity(i);
//			et_email.setText("");
//			et_pass.setText("");
			finish();
			return;
		}
//		et_email.setText("");
//		et_pass.setText("");


	}


	// Gcm Complete
	public void postData() throws NullPointerException {
		// TODO Auto-generated method stub

		try {
			Log.d("data", "sent");
			JSONObject json = new JSONObject();
			Log.d("email=", email);
			Log.d("password=", pass);

			json.put("email", email);
			json.put("password", pass);


			String url = StaticData.getlink(getApplicationContext()) + "login.php";

			Log.d("url------", url);

			ServiceHandler sh = new ServiceHandler();
			// Making a request to url and getting response
			String jsonStr = sh.makeRequest(url, ServiceHandler.POST, json.toString());
			result = jsonStr;
		} catch (Throwable t) {
			Toast.makeText(this, "Request failed: " + t.toString(),Toast.LENGTH_LONG).show();
		}
		try {
			Response_code = result;
		} catch (Exception e) {
			//e.printStackTrace();
		}
	}


}
